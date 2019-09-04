@extends('Layouts.main')

@section('title')
    @lang('strings.contact_us')
@endsection

@section('content')
    <div>
        <div class="dark">
            <div class="blurred-cover"
                style="background-image:url('../images/logo1x - app store.png');"></div>
        </div>
        <main id="main">
            <section class="hero">
                <div class="app-container container-fluid">
                    <div class="app-container-wrapper">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="privacy">
                                    <h1 class="text-center">@lang('privacy.privacy_title')</h1><br>
                                    <h2>@lang('privacy.information_collection')</h2>
                                    <p>@lang('privacy.we_dont_collect_any')</p>

                                    <h3>@lang('privacy.types_of_data_collected')</h3>
                                    <p>@lang('privacy.we_dont_collect_any')</p>
                                    <p>@lang('privacy.we_will_only_ask')</p>
                                    <h4>@lang('privacy.personal_data')</h4>
                                    <p>@lang('privacy.while_using_contact_us_page')</p>

                                    <ul>
                                        <li>@lang('privacy.first_name_last_name_email')</li>
                                    </ul>

                                    <h2>@lang('privacy.data_usage')</h2>

                                    <p>@lang('privacy.uses_collected_data')</p>
                                    <ul>
                                        <li>@lang('privacy.customer_support')</li>
                                    </ul>

                                    <h2>@lang('privacy.in_app_purchases_title')</h2>
                                    <p>@lang('privacy.in_app_purchases_content')</p>

                                    <h2>@lang('privacy.ads_title')</h2>
                                    <p>@lang('privacy.ads_content')</p>

                                    <h2>@lang('privacy.external_sites_title')</h2>
                                    <p>@lang('privacy.external_sites_content')</p>
                                    <p>@lang('privacy.external_sites_content_2')</p>

                                    <h2>@lang('privacy.disclosure_of_data')</h2>
                                    <p>@lang('privacy.we_dont_disclose')</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection