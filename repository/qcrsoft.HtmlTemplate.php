<?php
class HtmlTemplate
{
	// 当前块
	private $currentBlock;

	// 块堆栈
	private $stack = array();
	#endregion

	/// 输出结果
	public function GetText()
	{
		if (strlen($this->currentBlock->GetHtml())==0)
		{
			$this->Flush();
		}
		return $this->currentBlock->GetHtml();
	}

	public function __construct($filename)
	{
	    $this->$Filename = $filename;

		$handle = fopen($filename, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
    	$text = fread($handle, filesize ($filename));
	    fclose($handle);

		$this->currentBlock = new Block("", $text);
	}

	/// 打开块
	/// </summary>
	/// <param name="blockName">块名称</param>
	public function OpenBlock($blockName)
	{
		array_push($this->stack, $this->currentBlock);
		$this->currentBlock = new Block($blockName, $this->currentBlock->StringBuilder);
		//$this->sb = $this->currentBlock->StringBuilder;
	}

	/// 关闭块
	public function CloseBlock()
	{
		$block = array_pop($this->stack);
		$block->StringBuilder = str_replace($this->currentBlock->Text, $this->currentBlock->GetHtml(), $block->StringBuilder);
		$this->currentBlock = $block;
		//$this->sb = $this->currentBlock->StringBuilder;
	}

	/// 输出缓存文本
	public function Flush()
	{
		$this->currentBlock->Append($this->currentBlock->StringBuilder);
		$this->currentBlock->StringBuilder = $this->currentBlock->InnerText;
	}

	public function Append($text)
	{
		$this->currentBlock.Append($text);
	}

	/// 替换标签
	public function ReplaceVar($tagName, $value)
	{
		$this->currentBlock->StringBuilder = str_replace("\$$tagName", $value, $this->currentBlock->StringBuilder);
	}

	public $Filename;

	public $Text;
}

class Block
{
	public $Name;

	public $Text;

	public $StringBuilder;

	public $InnerText;

	private $buffer;

	public function GetHtml()
	{
		return $this->buffer;
	}

	public function Append($text)
	{
		$this->buffer .= $text;
	}

	public function __construct($name, $sb)
	{
		if (strlen($name)==0)
		{
			$this->StringBuilder = $sb;

			$this->Text = $sb;
			$this->InnerText = $sb;
		}
		else
		{
			$this->Name = $name;

			$beginTag = "<!--start $name-->";
			$endTag = "<!--end $name-->";

			//开始、结束标签的起始位置
			$startIndex = stripos($sb, $beginTag);
			$endIndex = stripos($sb, $endTag);

			if ($startIndex === false || $endIndex == false || $endIndex < $startIndex)
			{
				throw new Exception("区块$name不存在或不完整");
			}

			$length = $endIndex - $startIndex + strlen($endTag);
			$this->Text = substr($sb, $startIndex, $length);

			$length = $endIndex - $startIndex - strlen($beginTag);
			$this->InnerText = substr($sb, $startIndex + strlen($beginTag), $length);

			$this->StringBuilder = $this->InnerText;
		}
	}
}
