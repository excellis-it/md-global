<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\ContactPageCms;
use App\Models\ContactUs;
use App\Models\FooterCms;
use App\Models\FooterSocialLink;
use App\Models\HomeContent;
use App\Models\HomePage;
use App\Models\Logo;
use App\Models\PrivacyPolicy;
use App\Models\Qna;
use App\Models\TelehealthCms;
use App\Models\TermsAndCondition;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\CodeCleaner\ReturnTypePass;

class CmsController extends Controller
{
    use ImageTrait;

    public function homeIndex()
    {
        $homePage = HomePage::orderBy('id', 'desc')->get();
        return view('admin.cms.home.list', compact('homePage'));
    }


    public function homeStore(Request $request)
    {
        $request->validate([
            // 'title' => 'required',
            // 'sub_title' => 'required',
            // 'image' => 'required',
            // 'type' => 'required',
        ]);
        if ($request->hidden_id != null) {
            $homePage = HomePage::find($request->hidden_id);
            $message = 'Home page details has been updated successfully';
        } else {
            $homePage = new HomePage();
            $message = 'Home page details has been added successfully';
        }
        $homePage->title = $request->title;
        $homePage->sub_title = $request->sub_title;
        if ($request->hasFile('image')) {
            $image = $this->imageUpload($request->file('image'), 'home-page');
            $homePage->image = Storage::url($image);
        }
        $homePage->type = 1;
        $homePage->save();
        return redirect()->back()->with('message', $message);
    }

    public function homeEdit(Request $request)
    {
        $homePage = HomePage::find($request->id);
        return response()->json(['homePage' => $homePage, 'message' => 'Home page details found successfully.']);
    }

    public function homeDelete($id)
    {
        $homePage = HomePage::findOrFail($id);
        $homePage->delete();
        return redirect()->back()->with('error', 'Home page details has been deleted successfully');
    }

    public function qnaIndex()
    {
        $qnas = Qna::orderBy('id', 'desc')->get();
        return view('admin.cms.qna.list', compact('qnas'));
    }

    public function qnaChangeStatus(Request $request)
    {
        // return $request->all();
        $qna = Qna::find($request->id);
        $qna->status = $request->status;
        $qna->save();
        return response()->json(['status' => 'success', 'message' => 'Status has been changed successfully']);
    }

    public function qnaDelete($id)
    {
        $qna = Qna::findOrFail($id);
        $qna->delete();
        return redirect()->back()->with('success', 'Qna has been deleted successfully');
    }

    public function qnaStore(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $qna = new Qna();
        $qna->question = $request->question;
        $qna->answer = $request->answer;
        $qna->status = true;
        $qna->save();
        return redirect()->back()->with('message', 'Qna has been added successfully');
    }

    public function qnaEdit(Request $request)
    {
        $qna = Qna::find($request->id);
        return response()->json(['qna' => $qna, 'message' => 'Qna details found successfully.']);
    }

    public function qnaUpdate(Request $request)
    {
        $request->validate([
            'edit_question' => 'required',
            'edit_answer' => 'required',
        ]);

        $qna = Qna::find($request->id);
        $qna->question = $request->edit_question;
        $qna->answer = $request->edit_answer;
        $qna->save();
        return redirect()->back()->with('message', 'Qna has been updated successfully');
    }

    public function contactUsIndex()
    {
        $contactUs = ContactPageCms::orderBy('id', 'desc')->first();
        return view('admin.cms.contact-us.update')->with(compact('contactUs'));
    }

    public function contactUsUpdate(Request $request)
    {
        $request->validate([
            'contact_page_title' => 'required|max:255',
            'visit_us' => 'required',
            'call_us' => 'required',
            'mail_us' => 'required',
        ]);

        try {
            $contactUs = ContactPageCms::orderBy('id', 'desc')->first();
            $contactUs->contact_page_title = $request->contact_page_title;
            $contactUs->visit_us = $request->visit_us;
            $contactUs->call_us = $request->call_us;
            $contactUs->mail_us = $request->mail_us;
            $contactUs->meta_title=$request->meta_title;
            $contactUs->meta_description=$request->meta_description;
            $contactUs->meta_keyword=$request->meta_keyword;
            $contactUs->save();
            return redirect()->back()->with('message', 'Contact us page details has been updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function termsAndConditionIndex()
    {
        $terms = TermsAndCondition::orderBy('id', 'desc')->get();
        return view('admin.cms.terms-and-condions.list')->with(compact('terms'));
    }

    public function termsAndConditionCreate()
    {
        return view('admin.cms.terms-and-condions.create');
    }

    public function termsAndConditionEdit(Request $request)
    {
        $terms = TermsAndCondition::findOrFail($request->id);
        return view('admin.cms.terms-and-condions.update')->with(compact('terms'));
    }

    public function termsAndConditionDelete($id)
    {
        $terms = TermsAndCondition::findOrFail($id);
        $terms->delete();
        return redirect()->back()->with('error', 'Terms & Condition page details has been deleted successfully');
    }

    public function termsAndConditionStore(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:terms_and_conditions',
            'content' => 'required',
        ]);

        $terms = new TermsAndCondition();
        $terms->type = $request->type;
        $terms->content = $request->content;
        $terms->save();
        return redirect()->route('cms.terms-and-condition.index')->with('message', 'Terms & Condition page details has been added successfully');
    }

    public function termsAndConditionUpdate(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:terms_and_conditions,type,' . $request->id,
            'content' => 'required',
        ]);

        $terms = TermsAndCondition::findOrFail($request->id);
        $terms->type = $request->type;
        $terms->content = $request->content;
        $terms->save();
        return redirect()->route('cms.terms-and-condition.index')->with('message', 'Terms & Condition page details has been updated successfully');
    }

    public function privacyPolicyIndex()
    {
        $privacyPolicies = PrivacyPolicy::orderBy('id', 'desc')->get();
        return view('admin.cms.privacy-policy.list')->with(compact('privacyPolicies'));
    }

    public function privacyPolicyCreate()
    {
        return view('admin.cms.privacy-policy.create');
    }

    public function privacyPolicyEdit(Request $request)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($request->id);
        return view('admin.cms.privacy-policy.update')->with(compact('privacyPolicy'));
    }

    public function privacyPolicyDelete($id)
    {
        $privacyPolicy = PrivacyPolicy::findOrFail($id);
        $privacyPolicy->delete();
        return redirect()->back()->with('error', 'Privacy policy page details has been deleted successfully');
    }

    public function privacyPolicyStore(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:privacy_policies',
            'content' => 'required',
        ]);

        $privacyPolicy = new PrivacyPolicy();
        $privacyPolicy->type = $request->type;
        $privacyPolicy->content = $request->content;
        $privacyPolicy->save();
        return redirect()->route('cms.privacy-policy.index')->with('message', 'Privacy policy page details has been added successfully');
    }


    public function privacyPolicyUpdate(Request $request)
    {
        $request->validate([
            'type' => 'required|unique:privacy_policies,type,' . $request->id,
            'content' => 'required',
        ]);

        $privacyPolicy = PrivacyPolicy::findOrFail($request->id);
        $privacyPolicy->type = $request->type;
        $privacyPolicy->content = $request->content;
        $privacyPolicy->save();
        return redirect()->route('cms.privacy-policy.index')->with('message', 'Privacy policy page details has been updated successfully');
    }

    public function homeContentIndex()
    {
        $home = HomeContent::orderBy('id', 'desc')->first();
        return view('admin.cms.home-content.update')->with(compact('home'));
    }

    public function homeUpdate(Request $request)
    {
        $request->validate([
            'section_1_title' => 'required|max:255',
            'section_1_description' => 'required',
            'section_2_title' => 'required|max:255',
            'section_2_description' => 'required',
            'colab_section_1_title'=> 'required|max:255',
            'colab_section_1_description'=> 'required',
            'colab_section_1_link'=> 'required|url',
            'colab_section_2_title'=> 'required|max:255',
            'colab_section_2_description'=> 'required',
            'colab_section_2_link'=> 'required|url',
            'colab_section_3_title'=> 'required|max:255',
            'colab_section_3_description'=> 'required',
            'colab_section_3_link'=> 'required|url',
            'about_section_title'=> 'required|max:255',
            'about_section_description'=> 'required',
            'about_section_link'=> 'required|url',
            'services_section_title'=> 'required|max:255',
            'testimonial_section_title'=> 'required',
        ]);

        try {
            if ($request->id != null) {
                $home = HomeContent::find($request->id);
            } else {
                $home = new HomeContent();
            }
            $home->section_1_title = $request->section_1_title;
            $home->section_1_description = $request->section_1_description;
            $home->section_2_title = $request->section_2_title;
            $home->section_2_description = $request->section_2_description;

            $home->colab_section_1_title = $request->colab_section_1_title;
            $home->colab_section_1_description = $request->colab_section_1_description;
            $home->colab_section_1_link = $request->colab_section_1_link;
            $home->colab_section_2_title = $request->colab_section_2_title;
            $home->colab_section_2_description = $request->colab_section_2_description;
            $home->colab_section_2_link = $request->colab_section_2_link;
            $home->colab_section_3_title = $request->colab_section_3_title;
            $home->colab_section_3_description = $request->colab_section_3_description;
            $home->colab_section_3_link = $request->colab_section_3_link;
            $home->about_section_title = $request->about_section_title;
            $home->about_section_description = $request->about_section_description;
            $home->about_section_link = $request->about_section_link;
            $home->services_section_title = $request->services_section_title;
            $home->testimonial_section_title = $request->testimonial_section_title;
            $home->meta_title=$request->meta_title;
            $home->meta_description=$request->meta_description;
            $home->meta_keyword=$request->meta_keyword;

            $home->save();
            return redirect()->back()->with('message', 'Home page details has been updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function logoIndex()
    {
        $logo = Logo::orderBy('id', 'desc')->first();
        return view('admin.cms.logo.update')->with(compact('logo'));
    }

    public function logoUpdate(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'required|mimes:ico,svg,png,jpg,jpeg|max:2048',
        ]);

        try {
            if ($request->id != null) {
                $logo = Logo::find($request->id);
            } else {
                $logo = new Logo();
            }
            if ($request->hasFile('logo')) {
                $logo->logo = $this->imageUpload($request->file('logo'), 'logo');
            }
            if ($request->hasFile('favicon')) {
                $logo->favicon = $this->imageUpload($request->file('favicon'), 'favicon');
            }
            $logo->save();
            return redirect()->back()->with('message', 'Logo details has been updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function footerIndex()
    {
        $footer = FooterCms::orderBy('id', 'desc')->first();
        return view('admin.cms.footer.update')->with(compact('footer'));
    }

    public function footerUpdate(Request $request, $id)
    {
        // dd( $request->all());
        $request->validate([
            'footer_description' => 'required',
            'website_name' => 'required',
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'business_phone' => 'required',
            'newsletter_title' => 'required',
        ]);

        try {
            $footer = FooterCms::find($id);
            $footer->footer_description = $request->footer_description;
            $footer->website_name = $request->website_name;
            $footer->address = $request->address;
            $footer->email = $request->email;
            $footer->phone = $request->phone;
            $footer->business_phone = $request->business_phone;
            $footer->newsletter_title = $request->newsletter_title;
            $footer->save();

            if ($request->has('link')) {
                FooterSocialLink::where('footer_cms_id', $id)->delete();
                foreach ($request->link as $key => $link) {
                    $socialLink = new FooterSocialLink();
                    $socialLink->footer_cms_id = $id;
                    $socialLink->icon = $request->icon[$key];
                    $socialLink->link = $link;
                    $socialLink->save();
                }
            }
            return redirect()->back()->with('message', 'Footer details has been updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function telehealthIndex()
    {
        $telehealth = TelehealthCms::orderBy('id', 'desc')->first();
        return view('admin.cms.telehealth.update')->with(compact('telehealth'));
    }

    public function telehealthUpdate(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'symptom_title' => 'required|max:255',
            'symptom_description' => 'required',
            'offer_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'offer_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'offer_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'specialization_title' => 'required|max:255',
            'how_it_works_title' => 'required|max:255',
            'how_it_works_icon_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'how_it_works_icon_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'how_it_works_icon_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'how_it_works_icon_1_title' => 'required|max:255',
            'how_it_works_icon_2_title' => 'required|max:255',
            'how_it_works_icon_3_title' => 'required|max:255',
        ]);

        try {
            $telehealth = TelehealthCms::find($id);
            $telehealth->symptom_title = $request->symptom_title;
            $telehealth->symptom_description = $request->symptom_description;
            if ($request->hasFile('offer_image_1')) {
                $telehealth->offer_image_1 = $this->imageUpload($request->file('offer_image_1'), 'telehealth');
            }
            if ($request->hasFile('offer_image_2')) {
                $telehealth->offer_image_2 = $this->imageUpload($request->file('offer_image_2'), 'telehealth');
            }
            if ($request->hasFile('offer_image_3')) {
                $telehealth->offer_image_3 = $this->imageUpload($request->file('offer_image_3'), 'telehealth');
            }
            $telehealth->specialization_title = $request->specialization_title;
            $telehealth->how_it_works_title = $request->how_it_works_title;
            if ($request->hasFile('how_it_works_icon_1')) {
                $telehealth->how_it_works_icon_1 = $this->imageUpload($request->file('how_it_works_icon_1'), 'telehealth');
            }
            if ($request->hasFile('how_it_works_icon_2')) {
                $telehealth->how_it_works_icon_2 = $this->imageUpload($request->file('how_it_works_icon_2'), 'telehealth');
            }
            if ($request->hasFile('how_it_works_icon_3')) {
                $telehealth->how_it_works_icon_3 = $this->imageUpload($request->file('how_it_works_icon_3'), 'telehealth');
            }
            $telehealth->how_it_works_icon_1_title = $request->how_it_works_icon_1_title;
            $telehealth->how_it_works_icon_2_title = $request->how_it_works_icon_2_title;
            $telehealth->how_it_works_icon_3_title = $request->how_it_works_icon_3_title;
            $telehealth->meta_title=$request->meta_title;
            $telehealth->meta_description=$request->meta_description;
            $telehealth->meta_keyword=$request->meta_keyword;

            $telehealth->save();
            return redirect()->back()->with('message', 'Telehealth details has been updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
