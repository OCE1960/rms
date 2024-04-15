<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Verify Result Response</title>
    </head>
        <style>

            table {
                margin-bottom: 40px;
            }

            td {
                padding:5px;
                text-align: center;
            }

            .text-center {
                text-align: center;
                }

            .margin-bottom {
                margin-bottom: 20px;
            }

            .header {
                font-size: 30px;
                font-weight: 900;
            }
        </style>
    <body>

        <div class="col-12">

            @php
                $school = $verifyResultRequest->school;
            @endphp

            <!-- <img src="{{ public_path('letter-head/header.jpg') }}" width="100%" height="65" /> -->

            <div class="text-center header">{{  $school->full_name  }} </div>
            <div class="text-center margin-bottom">
                {{  $school->address_mailbox  }} <br/>
                {{  $school->address_street  }} <br/>
                {{  $school->official_email}} <br/>
                {{  $school->official_website  }}
            </div>

            <div class="mt-5">

                <h3>Dear {{ $verifyResultRequest->requestedBy->full_name }}, </h3>

                {!!  $response !!}

                <br>
                <br>
                <br>
                <br>

                Thanks and Kind regards <br>
                <strong> {{ auth()->user()->full_name }} </strong>

            </div>




        </div>

    </body>
</html>
