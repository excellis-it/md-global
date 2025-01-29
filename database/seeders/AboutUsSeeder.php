<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aboutUs = new AboutUs();
        $aboutUs->content = 'Lorem ipsum dolor sit amet consectetur. Pharetra netus cursus nec facilisis. Quis ultrices morbi maecenas lobortis. Mattis sed nisi amet nisi elit nunc nibh in. Ac convallis fringilla tortor morbi vel massa et et. Elementum pellentesque quis nunc elit. Urna pellentesque venenatis egestas ac neque a. Consequat mi at quis sed tincidunt leo sed sit. Pretium mauris imperdiet ornare nunc ut enim. Erat viverra urna sed quis et varius lectus ipsum mollis. Ullamcorper pellentesque lectus sed tellus fames dolor turpis nibh pharetra. Aliquam tortor nascetur nec neque porttitor molestie quis non arcu. Pretium lectus eu vitae diam sapien pellentesque nisl. Euismod auctor arcu cras facilisi tortor facilisis consectetur.

        Amet ultrices augue lorem iaculis tortor massa velit. Phasellus sapien non ac tortor convallis fringilla. Sapien massa nunc aliquam platea pulvinar morbi dictum. Quis eget at magna sem mi dui elit. Nisl leo facilisis faucibus non posuere enim senectus. Lorem volutpat ante mollis pulvinar nibh tristique eu. Neque malesuada enim tellus tristique sem senectus ornare pharetra. Ipsum est a bibendum pretium viverra cras turpis massa.
        
        Neque id tristique auctor accumsan dolor lorem praesent volutpat cras. Id auctor in tempor egestas ornare faucibus. Viverra nisi quis lacinia lorem sed tellus mattis aliquet. Sed nam nulla sit eu feugiat nisi elementum urna laoreet. Nulla sit interdum amet nisl et. Fames senectus cursus ullamcorper varius feugiat.
        
        ';
        $aboutUs->save();
        
    }
}
