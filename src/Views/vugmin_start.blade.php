<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('VugTech Activator')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="shortcut icon" href="{{ getImage('assets/images/logoIcon/favicon.png') }}" type="image/x-icon">
    <style>
        @media (min-width: 768px) {
            .h-md-100 {
                height: 100% !important;
            }
        }
    </style>
</head>
<body style="overflow-x: hidden">

<div class="installation-section h-100 padding-bottom d-grid place-content-center padding-top">
    <div class="" style="width: 100vw;height: 100vh">

        <div class="row h-100">
            <div class="col-12 p-0 col-md-6 bg-primary align-self-center h-auto h-md-100" style="background-color: #434bdf !important;">
                <div class="d-grid h-100 py-3 place-content-center" style="background: linear-gradient(to bottom,transparent,rgba(0,0,0,.5))">
                    <img src="{{ getImage('assets/images/installer/img.png') }}" class="w-md-75 img-fluid" alt="image missing">
                    <h2 class="font-weight-bolder my-4 text-white">
                       <b> VUGTECH ACTIVATOR</b>
                    </h2>
                        <small class="text-white">Made by Vugtech</small>
                </div>

            </div>

            <div class="col-12 col-md-6 align-self-center align-items-center py-3">
                <div class="px-3 ">
                    <div class="row mt-4">
                        <div class="col-12 ">
                            <div class="alert-area alert alert-danger d-none">
                                <h5 class="resp-msg"></h5>
                                <p class="my-3">@lang('You can ask for support by creating a support ticket.')</p>
                                <a href="{{ Vugtech\Vugmin\VugiChugi::splnk() }}" class="btn btn-outline-primary btn-sm"
                                   target="_blank">@lang('create  ticket')</a>
                            </div>

                        </div>
                    </div>
                    <div class="alert alert-success" role="alert">
                        <p class="fs-17 mb-0">@lang('To validate your purchase details, following information will sent to vugtech server.')</p>
                    </div>
                    <div class="alert alert-primary" role="alert">
                        <p class="fs-17">@lang('Application'): {{ systemDetails()['name'] }} -
                            v{{ systemDetails()['version'] }}</p>
                        <p class="fs-17">@lang('Envato Username'): <span class="envato_username"></span></p>
                        <p class="fs-17">@lang('Purchase Code'): <span class="purchase_code"> </span></p>
                        <p class="fs-17">@lang('Your Email'): <span class="email"></span></p>
                        <p class="fs-17 mb-0 word-break-all">@lang('Activation URL')
                            : {{ Vugtech\Vugmin\Helpmate::appUrl() }}</p>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <p class="fs-17 mb-0">@lang('We never collect any sensitive or confidential data.')</p>
                    </div>
                </div>
                <div class="px-3">
                    <p>@lang('The purchase code(license) is for one website or domain only. Please activate the license into the correct domain(URL) to avoid any unwanted issues in the future.')</p>
                    <form class="verForm">
                        <div class="information-form-group">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <label for="purchase_code" class="mb-1">@lang('Enter Purchase Code')
                                        <span class="text-danger">*</span></label>
                                </div>
                                <div class="p-code-info" data-bs-toggle="tooltip" data-bs-html="true"
                                     title='To get the purchase code <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">click here</a>'>
                                    <i class="fas fa-info-circle"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" name="purchase_code" id="purchase_code"
                                   required>
                        </div>
                        <div class="information-form-group">
                            <label for="username" class="mb-1">@lang('Enter Envato Username') <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="envato_username" id="username"
                                   required>
                        </div>
                        <div class="information-form-group">
                            <label for="email" class="mb-1">@lang('Enter Your Email') <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>

                        <div class="information-form-group gap-2 d-flex">
                            <input type="checkbox" id="agree" class="w-auto mx-2 h-auto mt-1" required>
                            <label for="agree" class="agree-label">@lang('I accept the terms of the') <a
                                    href="https://codecanyon.net/licenses/standard"
                                    target="_blank">@lang('Envato Standard License')</a> @lang('as well as the vugtech terms and conditions.')
                            </label>
                        </div>
                        <div class="text-end">
                            <button type="submit"
                                    class="btn btn-primary choto sbmBtn">@lang('Activate Now')</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/global/js/jquery-3.5.1.min.js') }}"></script>
@include('partials.notify')
<script>
    (function ($) {
        "use strict"

        $('.verForm').submit(function (e) {
            e.preventDefault();
            $('.alert-area').addClass('d-none');
            $('.sbmBtn').text('Processing...');
            var url = '{{ route(Vugtech\Vugmin\VugiChugi::acRouterSbm()) }}';
            var data = {
                "purchase_code": $(this).find('[name=purchase_code]').val(),
                "email": $(this).find('[name=email]').val(),
                "envato_username": $(this).find('[name=envato_username]').val()
            };

            $.post(url, data, function (response) {
                if (response.type == 'error') {
                    $('.sbmBtn').text('Submit');
                    $('.verForm').trigger("reset");
                    $('.alert-area').removeClass('d-none');
                    $('.resp-msg').text(response.message);
                } else {
                    location.reload();
                }
            });

        });

        $(function () {
            $('[data-bs-toggle="tooltip"]').tooltip({
                animated: 'fade',
                trigger: 'click'
            })
        })

        $('[name=email]').on('input', function () {
            $('.email').text($(this).val());
        });

        $('[name=envato_username]').on('input', function () {
            $('.envato_username').text($(this).val());
        });

        $('[name=purchase_code]').on('input', function () {
            $('.purchase_code').text($(this).val());
        });

    })(jQuery);
</script>
<style>
    .d-grid {
        place-content: center;
        place-items: center;
        display: grid;
    }
</style>
</body>

</html>
