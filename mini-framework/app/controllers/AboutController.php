<?php

class AboutController
{

    public function index()
    {
        $company = "HE-Arc";
        return Helper::view("about", ['company' => $company]);
    }

}
