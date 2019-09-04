@extends('Layouts.main')

@section('title')
    Home
@endsection

@section('content')
    <div>
        <div class="dark">
            <div class="blurred-cover"
                style="background-image:url('../images/logo1x - app store.png');"></div>
        </div>
        @if(session()->has('data'))
            <div class="text-center bg-{{session()->get('data')['type']}}">
                <h4>
                    {{session()->get('data')['msg']}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>
            </div>
        @endif
        <main id="main">
            <section class="hero">
                <div class="app-container container-fluid">
                    <div class="app-container-wrapper">
                        <div class="row">
                            <div class="col-sm-5 col-xs-12">
                                <div class="phone-container"><img src="images/phoneframe.png" class="frame-image"/>
                                    <div id="carousel" class="carousel fade" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="item active"><img
                                                        src="images/@lang('images.image_1')"
                                                        alt="images/43732b9f-043b-499a-a9e7-2821e9919e75-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="images/@lang('images.image_2')"
                                                        alt="images/2a3fe3de-c749-4690-bd88-969c81a2c811-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="images/@lang('images.image_3')"
                                                        alt="images/7a04f195-844a-46b4-95a5-c2963b9f40e1-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="images/@lang('images.image_4')"
                                                        alt="images/ee520765-b472-468a-85b6-cec97a6929e8-screenshot.png"/>
                                            </div>
                                            <div class="item "><img
                                                        src="images/@lang('images.image_5')"
                                                        alt="images/9c9c5eb5-ebe5-4018-84aa-48a7b854b4d3-screenshot.png"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7 col-xs-12">
                                <div class="app-content"><h2 class="app-name app-field">@lang('strings.app_name')</h2>
                                    <h1 class="tag-line app-field">@lang('strings.app_field_title')</h1>
                                    <div class="description app-field"><p>@lang('strings.description')</p></div>
                                    <div>
                                        <a class="app-link" id="appleLink" href="@lang('strings.app_store_url')" target="_blank">
                                            <img class="app-icon" src="images/@lang('images.app_store')"/>
                                        </a>
                                        <a class="app-link" id="googleLink" href="@lang('strings.play_store_url')" target="_blank">
                                            <img class="play-store" src="images/@lang('images.play_store')"/>
                                        </a>
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