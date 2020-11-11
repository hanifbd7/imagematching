<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use KubAT\PhpSimple\HtmlDomParser;

class ImageController extends Controller
{
   
    private $tagsArr;


    /**
     * Display image searching form.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        return view('search');
    }

    /**
     * Show the searching result.
     *
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request)
    {
        
        try {

            $sites = trim($request->txt_siteUrl);
            $tags = trim($request->txt_tag);
            $image = $request->txt_image;


            // convert siteurls and tags into array
            $this->tagsArr = explode(',', $tags);
            $siteArr = explode(PHP_EOL, $sites);


            // upload image file in order to generate file hash
            $fileName = time().'.'.$request->file_image->extension(); 
            $request->file_image->move(public_path('uploads'), $fileName);
            $image_location = public_path('uploads').'\\'. $fileName;


            // call function to generate hash file
            $file_hash = $this->generateFileHash($image_location);
    

            // declare two array to hold matched results
            $matched_images = array();
            $matched_tags = array();


            // call funciton to parse site url and fetch images
            $images = $this->parsePageForImage($siteArr);

            // matching each image
            foreach ($images as $img):
                    $image_url = $img['url'];
                    // generae hash for this image
                    $image_hash = $this->generateFileHash($image_url);

                    if ($image_hash == $file_hash){
                        $matched_images[] = $image_url;
                    }

                   // match tags with image name and alt
                   if ($this->matchTags($image_url.' '.$img['alt'])){
                      $matched_tags[] = $image_url;
                   }

            endforeach;


            return view('result', compact('matched_images','matched_tags'));

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    } 



    /**
    * check a tag with image name and alt
    * @param String  $image_url
    * @return bool TRUE/FALSE 
    * 
    */
    public function matchTags($image_url){
        $matched = false;
        foreach ($this->tagsArr as $key => $tag) {
            if (strpos($image_url, $tag) !== false)
                $matched =  true;
        }

        return $matched;
    }


   /**
    * generate hash for provided file
    * @param String $file_url
    * @return String file hash
    */
    public function generateFileHash($file_url){
        try {
             $file_hash = hash_file('md5', $file_url);
             return $file_hash;
        }catch(\Exception $exception){ }
    }



    /**
    * crawl site url to fetch images
    * @param Array $siteArr - a list of site url
    * @return Array  - an of images url and image alt
    */
    public function parsePageForImage($siteArr){

            $imageArr = array();

            // Parse each site url
            foreach ($siteArr as $site):

                try {
                    $dom = HtmlDomParser::file_get_html($site);
                    // Find all images
                    foreach($dom->find('img') as $key => $element):
                        $imageArr[$key]['url'] = $element->src;
                        $imageArr[$key]['alt'] = $element->alt;
                    endforeach;
                }catch(\Exception $exception){ }

            endforeach;

            // remove broken images
            return array_filter($imageArr);
    }

    
}
