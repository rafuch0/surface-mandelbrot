<?php
if (isset($_GET['3141592654'])) die(highlight_file(__FILE__, 1));

function getPageJS($canvas, $width, $height)
{
	$output = '';

	$output .= '<script src="surface.js"></script>';

	$output .= '<script>';

	$output .= "var canvas = '$canvas';";
	$output .= "var width = '$width';";
	$output .= "var height = '$height';";

	$output .= <<< 'EOD'

var scale = 100;
var xaxis = 170;
var yaxis = 100;
var iterations = 5;

var x, y, x0, y0, x2, y2;
var iteration;
var i, j;

function rando(limit)
{
	return (Math.random() > limit);
}

function drawMandel()
{
	if(rando(0.25))
	{
		if(rando(0.5))
		{
			scale += 11;
		}
		else
		{
			scale -= 5;
		}
	}
	else if(rando(0.25))
	{
		if(rando(0.5))
		{
			iterations += 5;
		}
		else
		{
			iterations -= 3;
		}
	}
	else if(rando(0.25))
	{
		if(rando(0.5))
		{
			yaxis += 120;
		}
		else
		{
			yaxis -= 80;
		}
	}
	else
	{
		if(rando(0.5))
		{
			xaxis -= 90;
		}
		else
		{
			xaxis += 60;
		}
	}

	for (j = 0 ; j < height; j++)
	{
		for (i = 0; i < width; i++)
		{
			iteration = 0;

			x = x0 = (i - xaxis) / scale;
			y = y0 = (j - yaxis) / scale;

			x2 = x * x;
			y2 = y * y;

			while ((x2 + y2 < 4) && (iteration < iterations))
			{
				y = 2 * x * y + y0;
				x = x2 - y2 + x0;
				x2 = x * x;
				y2 = y * y;

				iteration++;
			}

			if (iteration == iterations)
			{
				Surface.plot(i, j, '0x000000');
			}
			else
			{
				Surface.plot(i, j, '0x'+(iteration % 8 + 24)+(iteration % 12 + 6)+(iteration % 13));
			}
		}
	}

	Surface.render();
}

function main(canvas, width, height, mainFunc, loopFunc)
{
	var canvasContext = document.getElementById(canvas);

	Surface.init(canvasContext, width, height);

	mainFunc();

	Surface.loop(loopFunc, 60);
}

main(canvas, width, height, drawMandel, drawMandel);

EOD;
	$output .= '</script>';

	return $output;
}

function getPageHTML($canvas, $width, $height)
{
	$output = '';

	$output .= '<!DOCTYPE html>';
	$output .= '<html>';

		$output .= '<head>';

		$output .= '</head>';

		$output .= '<body>';

		$output .= '<canvas id="'.$canvas.'" width="'.$width.'" height="'.$height.'">';
		$output .= 'herp derp nice browser';
		$output .= '</canvas>';

		$output .= getPageJS($canvas, $width, $height);

		$output .= '</body>';

	$output .= '</html>';

	return $output;
}

$output = '';

$output .= getPageHTML('canvas', 500, 500);

echo $output;

?>
