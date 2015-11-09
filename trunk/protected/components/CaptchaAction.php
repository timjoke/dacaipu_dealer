<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CaptchaAction 的注释
 *
 * @作者 roy
 */
class CaptchaAction extends CCaptchaAction
{
    protected function generateVerifyCode()
    {
        $bvc = new busValidcode();
        return $bvc->random_words(4);
    }
    
    protected function renderImageGD($code)
	{
		$image = imagecreatetruecolor($this->width,$this->height);

		$backColor = imagecolorallocate($image,
				(int)($this->backColor % 0x1000000 / 0x10000),
				(int)($this->backColor % 0x10000 / 0x100),
				$this->backColor % 0x100);
		imagefilledrectangle($image,0,0,$this->width,$this->height,$backColor);
		imagecolordeallocate($image,$backColor);

		if($this->transparent)
			imagecolortransparent($image,$backColor);

		$foreColor = imagecolorallocate($image,
				(int)($this->foreColor % 0x1000000 / 0x10000),
				(int)($this->foreColor % 0x10000 / 0x100),
				$this->foreColor % 0x100);

		if($this->fontFile === null)
			$this->fontFile = dirname(__FILE__) . '/Arial.ttf';

		$length = strlen($code);
		$box = imagettfbbox(30,0,$this->fontFile,$code);
		$w = $box[4] - $box[0] + $this->offset * ($length - 1);
		$h = $box[1] - $box[5];
		$scale = min(($this->width - $this->padding * 2) / $w,($this->height - $this->padding * 2) / $h);
		$x = 10;
		$y = round($this->height * 27 / 40);
		for($i = 0; $i < $length; ++$i)
		{
			$fontSize = (int)(rand(26,32) * $scale * 0.8);
			$angle = rand(-10,10);
			$letter = $code[$i];
			$box = imagettftext($image,$fontSize,$angle,$x,$y,$foreColor,$this->fontFile,$letter);
			$x = $box[2] + $this->offset;
		}
                
                $doki_blue = imagecolorallocate($image, 0x1E, 0x90, 0xFF);
                for($i=0;$i<90;$i++)
                {
                    imagesetpixel($image,rand()%100,rand()%50,$doki_blue);
                }

                
		imagecolordeallocate($image,$foreColor);
                ob_clean();
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header("Content-Type: image/png");
		imagepng($image);
		imagedestroy($image);
	}

	/**
	 * Renders the CAPTCHA image based on the code using ImageMagick library.
	 * @param string $code the verification code
	 * @since 1.1.13
	 */
	protected function renderImageImagick($code)
	{
		$backColor=$this->transparent ? new ImagickPixel('transparent') : new ImagickPixel(sprintf('#%06x',$this->backColor));
		$foreColor=new ImagickPixel(sprintf('#%06x',$this->foreColor));

		$image=new Imagick();
		$image->newImage($this->width,$this->height,$backColor);

		if($this->fontFile===null)
			$this->fontFile=dirname(__FILE__).'/Arial.ttf';

		$draw=new ImagickDraw();
		$draw->setFont($this->fontFile);
		$draw->setFontSize(30);
		$fontMetrics=$image->queryFontMetrics($draw,$code);

		$length=strlen($code);
		$w=(int)($fontMetrics['textWidth'])-8+$this->offset*($length-1);
		$h=(int)($fontMetrics['textHeight'])-8;
		$scale=min(($this->width-$this->padding*2)/$w,($this->height-$this->padding*2)/$h);
		$x=10;
		$y=round($this->height*27/40);
		for($i=0; $i<$length; ++$i)
		{
			$draw=new ImagickDraw();
			$draw->setFont($this->fontFile);
			$draw->setFontSize((int)(rand(26,32)*$scale*0.8));
			$draw->setFillColor($foreColor);
			$image->annotateImage($draw,$x,$y,rand(-10,10),$code[$i]);
			$fontMetrics=$image->queryFontMetrics($draw,$code[$i]);
			$x+=(int)($fontMetrics['textWidth'])+$this->offset;
		}
                
                $doki_blue = imagecolorallocate($img, 0x1E, 0x90, 0xFF);
                for($i=0;$i<90;$i++)
                {
                    imagesetpixel($img,rand()%70,rand()%30,$doki_blue);
                }

                ob_clean();
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-Transfer-Encoding: binary');
		header("Content-Type: image/png");
		$image->setImageFormat('png');
		echo $image;
	}
}
