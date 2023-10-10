<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Symfony\Component\Finder\Finder;


class GlobalController extends Controller
{
    public function languageSwitch($locale) {
        if(in_array($locale, ['ar', 'fr']))
            Session::put('locale', $locale);
        else
            Session::put('locale', 'fr');

        return redirect()->back();
    }

    public function maintenance()
    {
        $maintenance = setting('maintenance_mode');

        if($maintenance == "1")
            return view('clients.errors.maintenance');

        return redirect()->route('clients.home');
    }

    public function findTranslations() {
        $keys = array();

        $functions = array('__');

        $pattern =
            "[^\w|>]" .                         
            "(" . implode('|', $functions) . ")" .  
            "\(" .                          
            "[\'\"]" .                          
            "(" .                              
            "([^\1)]+)+" .               
            ")" .                             
            "[\'\"]" .                          
            "[\),]"; 

        $finder = new Finder();
        $finder->in(base_path('app'))
            ->in(base_path('resources/views'))
            ->in(base_path('app'))
            ->name('*.php')
            ->files();

        foreach ($finder as $file) {
            if (preg_match_all("/$pattern/siU", $file->getContents(), $matches)) {
                // Get all matches
                foreach ($matches[2] as $key) {
                    $new_key = str_replace('\\', '', $key);
                    $keys[$new_key] = "";
                }
            }
        }

        // Remove duplicates
        //$keys = array_unique($keys);
        return json_encode($keys, JSON_UNESCAPED_UNICODE);
    }
}
