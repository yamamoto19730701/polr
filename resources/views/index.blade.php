@extends('layouts.base')

@section('css')
<link rel='stylesheet' href='css/index.css' />
@endsection

@section('content')
<h1 class='title'>{{__(env('APP_NAME'))}}</h1>

<form method='POST' action='/shorten' role='form'>
    <input type='url' autocomplete='off'
        class='form-control long-link-input' placeholder='http://' name='link-url' />

    <div class='row' id='options' ng-cloak>
        <p>{{__("Customize link")}}</p>

        @if (!env('SETTING_PSEUDORANDOM_ENDING'))
        {{-- Show secret toggle only if using counter-based ending --}}
        <div class='btn-group btn-toggle visibility-toggler' data-toggle='buttons'>
            <label class='btn btn-primary btn-sm active'>
                <input type='radio' name='options' value='p' checked /> Public
            </label>
            <label class='btn btn-sm btn-default'>
                <input type='radio' name='options' value='s' /> Secret
            </label>
        </div>
        @endif

        <div>
            <div class='custom-link-text'>
                <h2 class='site-url-field'>{{env('APP_ADDRESS')}}/</h2>
                <input type='text' autocomplete="off" class='form-control custom-url-field' name='custom-ending' />
            </div>
            <div>
                <a href='#' class='btn btn-success btn-xs check-btn' id='check-link-availability'>{{__("Check Availability")}}</a>
                <div id='link-availability-status'></div>
            </div>
        </div>
    </div>
    <input type='submit' class='btn btn-info' id='shorten' value='{{__("Shorten")}}' />
    <a href='#' class='btn btn-warning' id='show-link-options'>{{__("Link Options")}}</a>
    <input type="hidden" name='_token' value='{{csrf_token()}}' />
</form>

<div id='tips' class='text-muted tips'>
    <i class='fa fa-spinner'></i> {{__("Loading Tips...")}}
</div>
@endsection

@section('js')
    <script>
        $(function() {
            var optionsButton = $('#show-link-options');
            $('#options').hide();
            var slide = 0;
            optionsButton.click(function() {
                if (slide === 0) {
                    $("#options").slideDown();
                    slide = 1;
                } else {
                    $("#options").slideUp();
                    slide = 0;
                }
            });
            $('#check-link-availability').click(function() {
                var custom_link = $('.custom-url-field').val();
                var request = $.ajax({
                    url: "/api/v2/link_avail_check",
                    type: "POST",
                    data: {
                        link_ending: custom_link
                    },
                    dataType: "html"
                });
                $('#link-availability-status').html('<span><i class="fa fa-spinner"></i> {{__("Loading")}}</span>');
                request.done(function(msg) {
                    if (msg == 'unavailable') {
                        $('#link-availability-status').html(' <span style="color:red"><i class="fa fa-ban"></i> {{__("Already in use")}}</span>');
                    } else if (msg == 'available') {
                        $('#link-availability-status').html('<span style="color:green"><i class="fa fa-check"></i> {{__("Available")}}</span>');
                    } else if (msg == 'invalid') {
                        $('#link-availability-status').html('<span style="color:orange"><i class="fa fa-exclamation-triangle"></i> {{__("Invalid Custom URL Ending")}}</span>');
                    } else {
                        $('#link-availability-status').html(' <span style="color:red"><i class="fa fa-exclamation-circle"></i> {{__("An error occured. Try again")}}</span>' + msg);
                    }
                });

                request.fail(function(jqXHR, textStatus) {
                    $('#link-availability-status').html(' <span style="color:red"><i class="fa fa-exclamation-circle"></i> An error occured. Try again</span>' + textstatus);
                });
            });
            min = 1;
            max = 2;
            var i = Math.floor(Math.random() * (max - min + 1)) + min;
            changeTips(i);
            var tipstimer = setInterval(function() {
                changeTips(i);
                i++;
            }, 8000);

            function setTip(tip) {
                $("#tips").html(tip);
            }

            function changeTips(tcase) {
                switch (tcase) {
                    case 1:
                        setTip('{{__("Create an account to keep track of your links")}}');
                        break;
                    case 2:
                        setTip('{{__("Did you know you can change the URL ending by clicking on Link Options?")}}');
                        i = 1;
                        break;
                }
            }
        });

        $(function() {
            // Setup drop down menu
            $('.dropdown-toggle').dropdown();

            // Fix input element click problem
            $('.dropdown input, .dropdown label').click(function(e) {
                e.stopPropagation();
            });
            $('.btn-toggle').click(function() {
                $(this).find('.btn').toggleClass('active');

                if ($(this).find('.btn-primary').size() > 0) {
                    $(this).find('.btn').toggleClass('btn-primary');
                }
                if ($(this).find('.btn-danger').size() > 0) {
                    $(this).find('.btn').toggleClass('btn-danger');
                }
                if ($(this).find('.btn-success').size() > 0) {
                    $(this).find('.btn').toggleClass('btn-success');
                }
                if ($(this).find('.btn-info').size() > 0) {
                    $(this).find('.btn').toggleClass('btn-info');
                }

                $(this).find('.btn').toggleClass('btn-default');

            });
        });


    </script>
@endsection
