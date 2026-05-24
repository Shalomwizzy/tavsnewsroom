<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeneratePwaIcons extends Command
{
    protected $signature   = 'pwa:generate-icons';
    protected $description = 'Generate PWA PNG icons matching the TNR SVG logo';

    public function handle(): void
    {
        $dir = public_path('icons');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        foreach ([180, 192, 512] as $size) {
            $this->generate($size, $dir);
            $this->info("Generated icon-{$size}.png");
        }
    }

    private function generate(int $size, string $dir): void
    {
        $k   = $size / 512.0;
        $img = imagecreatetruecolor($size, $size);
        imageantialias($img, true);

        $red   = imagecolorallocate($img, 220, 20, 60);
        $white = imagecolorallocate($img, 255, 255, 255);

        imagefill($img, 0, 0, $red);

        // Crossbar body: x=76..436, y=84..158
        imagefilledrectangle($img,
            (int)round(76*$k),  (int)round(84*$k),
            (int)round(435*$k), (int)round(157*$k),
            $white
        );

        // Left crossbar serif tab: x=76..116, y=68..174
        imagefilledrectangle($img,
            (int)round(76*$k),  (int)round(68*$k),
            (int)round(115*$k), (int)round(173*$k),
            $white
        );

        // Right crossbar serif tab: x=396..436, y=68..174
        imagefilledrectangle($img,
            (int)round(396*$k), (int)round(68*$k),
            (int)round(435*$k), (int)round(173*$k),
            $white
        );

        // Stem + base serifs (with ink traps)
        // SVG points: 210,150  222,158  290,158  302,150
        //             302,430  324,430  324,450
        //             188,450  188,430  210,430
        $this->poly($img, $white, $k, [
            210, 150,
            222, 158,
            290, 158,
            302, 150,
            302, 430,
            324, 430,
            324, 450,
            188, 450,
            188, 430,
            210, 430,
        ]);

        imagepng($img, $dir . '/icon-' . $size . '.png', 9);
    }

    /** Scale and fill a polygon. Vertex list is [x1,y1, x2,y2, ...] */
    private function poly(\GdImage $img, int $color, float $k, array $v): void
    {
        $pts = [];
        foreach ($v as $c) {
            $pts[] = (int) round($c * $k);
        }
        imagefilledpolygon($img, $pts, count($pts) / 2, $color);
    }
}
