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
                            <div class="col-sm-5 col-xs-12">
                                <div class="phone-container"><img src="@lang('strings.app_url')images/phoneframe.png"
                                                                  class="frame-image"/>
                                    <div id="carousel" class="carousel fade" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="item active"><img
                                                        src="../images/@lang('images.image_1')"
                                                        alt="images/43732b9f-043b-499a-a9e7-2821e9919e75-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="../images/@lang('images.image_2')"
                                                        alt="images/2a3fe3de-c749-4690-bd88-969c81a2c811-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="../images/@lang('images.image_3')"
                                                        alt="images/7a04f195-844a-46b4-95a5-c2963b9f40e1-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="../images/@lang('images.image_4')"
                                                        alt="images/ee520765-b472-468a-85b6-cec97a6929e8-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="../images/@lang('images.image_5')"
                                                        alt="images/9c9c5eb5-ebe5-4018-84aa-48a7b854b4d3-screenshot.png"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-xs-12">
                                <div class="app-content">
                                    <h1 class="tag-line app-field">@lang('strings.contact_us')</h1>
                                    <div class="description app-field">
                                        <form method="post" action="/support/{{Config::get('app.locale')}}"
                                              id="contact-form" novalidate>
                                            @csrf
                                            <div class="error">
                                                <p>
                                                    @if(session()->has('data'))
                                                        {{session()->get('data')['msg']}}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="lang" name="lang" aria-describedby="langHelp" value="{{Config::get('app.locale')}}">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="name" name="name"
                                                       aria-describedby="nameHelp"
                                                       placeholder="@lang('strings.your_name')"
                                                       value="@if(session()->has('data')){{session()->get('data')['name']}}@endif" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" id="email" name="email"
                                                       aria-describedby="emailHelp"
                                                       placeholder="@lang('strings.your_email')" value="@if(session()->has('data')){{session()->get('data')['email']}}@endif" required>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="message" id="message" class="form-control"
                                                          placeholder="@lang('strings.message')" rows="10" cols="55"
                                                          required></textarea>
                                            </div>
                                            <button type="submit"
                                                    class="btn btn-white">@lang('strings.submit_btn')</button>
                                        </form>
                                    </div>

                                    @include('Components.top-menu')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection