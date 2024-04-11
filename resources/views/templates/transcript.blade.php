<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Transcript Result</title>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
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

            @if ( ($academicResults) && count($academicResults) > 0)

                @php
                    $x = 0;
                    $totalUnitArray = [];
                    $totalGradePointArray = [];
                    $school = $userRequestingTranscript->school;
                @endphp

                <!-- <img src="{{ public_path('letter-head/header.jpg') }}" width="100%" height="65" /> -->
                <div class="text-center header">{{  $school->full_name  }} </div>
                <div class="text-center margin-bottom">
                    {{  $school->address_mailbox  }} <br/>
                    {{  $school->address_street  }} <br/>
                    {{  $school->official_email}} <br/>
                    {{  $school->official_website  }}
                </div>
                @foreach($academicResults as $semesterId => $semesterResults)

                    @php
                        $x = $x + 1;
                        $even = $x % 2 ;
                        $semester = $semesterResults[0]->semester;
                        $semesterResults = $semester->studentSemesterResult($userRequestingTranscript->id);
                        $semesterTotalCourseUnit = $semester->studentSemesterTotalCourseUnit($userRequestingTranscript->id);
                        $semesterTotalGradePoint = $semester->studentSemesterTotalGradePoint($userRequestingTranscript->id);
                        array_push($totalUnitArray, $semesterTotalCourseUnit);
                        array_push($totalGradePointArray,  $semesterTotalGradePoint);
                    @endphp

                <div class="table-responsive mt-2">




                    <div class="text-center semester-heading">
                    <span style="font-size: 20px;"> <strong>{{ $semester->semester_session }}  {{ $semester->semester_name }} </strong> </span>
                    </div>





                @if (count($semesterResults) > 0)

                    <table width="100%" border="1" cellpadding="2" cellspacing="0">
                        <thead>
                            {{-- <tr>

                                <th colspan="2">Title of Course</th>
                                <th colspan="2">Option</th>
                                <th colspan="2">Grade</th>
                            </tr> --}}
                            <tr>
                            <th width="10%">Course <br> Code</th>
                            <th width="46%" >Title of Course</th>
                            <th  width="7%">Units</th>
                            <th  width="10%">Grade</th>
                            <th  width="17%">Total Grade <br> Points</th>
                            <th width="10%">Cum <br> G.P.A</th>
                            </tr>
                        </thead>
                        <tbody>



                            @foreach ($semesterResults as $academicResult)


                                <tr class="grade-result">
                                    <td scope="col">{{ $academicResult->course->course_code}} </td>
                                    <td scope="col">
                                        {{ $academicResult->course->course_name }}
                                    </td>
                                    <td scope="col">{{ $academicResult->unit }}</td>
                                    <td scope="col">{{ $academicResult->grade }}</td>
                                    <td scope="col">{{ $academicResult->grade_point }}</td>
                                    <td scope="col"></td>
                                </tr>

                            @endforeach



                            <tr class="grade-display">
                                <td scope="col"></td>
                                <td scope="col" >

                                </td>
                                <td scope="col" cellpadding="20" > <strong> {{ $semesterTotalCourseUnit }} </strong> </td>
                                <td scope="col" ></td>
                                <td scope="col" > <strong> {{ $semesterTotalGradePoint }} </strong> </td>
                                <td scope="col" >  <strong> {{  number_format(array_sum($totalGradePointArray) / array_sum($totalUnitArray), 2) }} </strong> </td>
                            </tr>

                        </tbody>

                    </table>

                    @if ($even == 0  && $x < count($academicResults))

                     <pagebreak>

                      <h3>Transcript Results</h3>

                    @endif

                @else

                    <div class=" text-center text-danger my-2">
                        <h5>No Result Compiled Result for this Semester </h5>
                    </div>
                @endif


                                </div>




                            @endforeach
            @endif
        </div>

    </body>
</html>
