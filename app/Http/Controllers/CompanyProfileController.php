<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CompanyProfileController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:Update-Profile', ['only' => ['company_profile', 'update_company_profile']]);
    }

    public function company_profile()
    {
        $auth = Auth::user();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        return view('company_profile', compact('company_profile'))->with('pageTitle', 'Company Profile');
    }
    public function update_company_profile(Request $request)
    {
        $auth = Auth::user();
        $id=$request->id;
        $company_profile = CompanyProfile::where('cp_id', '=', $id)->where('company_id', $auth->company_id)->first();
        // dd($company_profile);
        $company_profile->cp_name = $request->name;
        $company_profile->company_id = $auth->company_id;
        $company_profile->cp_salogan = $request->salogan;
        $company_profile->cp_address = $request->address;
        $company_profile->cp_terms = $request->terms;
        $company_profile->cp_deal = $request->deal_in;
        $company_profile->cp_contact = $request->contact;

        // if ($request->hasFile('logo')) {
        //     if (File::exists($company_profile->cp_logo)) {
        //         File::delete($company_profile->cp_logo);
        //     }

        //     $fileNamet = 'logo' . '.' . $request->file('logo')->extension();
        //     $fileNameToStore = $request->logo->move('logo_images', $fileNamet);
        //     $company_profile->cp_logo = $fileNameToStore;
        // }
        if ($request->hasFile('logo')) {
            if (File::exists($company_profile->cp_logo)) {
                File::delete($company_profile->cp_logo);
            }

            $fileExtension = $request->file('logo')->extension();
            $fileName = 'logo_' . $auth->company_id . '_' . $company_profile->cp_id . '.' . $fileExtension;
            $fileNameToStore = $request->logo->move('logo_images', $fileName);
            $company_profile->cp_logo = $fileNameToStore;
        }
        $company_profile->save();
        return redirect()->route('company_profile');
    }
}
