
<div class="col-12">
    @if ( isset($semesters) && ($selectedTask) && count($semesters) > 0)

        
        @php
            $x = 0;
            $totalUnitArray = [];
            $totalGradePointArray = [];
        @endphp
        
        @foreach($semesters as $semester)

            @php
                $semesterResults = $semester->studentSemesterResult($userRequestingTranscript->id);
                $semesterTotalCourseUnit = $semester->studentSemesterTotalCourseUnit($userRequestingTranscript->id);
                $semesterTotalGradePoint = $semester->studentSemesterTotalGradePoint($userRequestingTranscript->id);
                array_push($totalUnitArray, $semesterTotalCourseUnit);
                array_push($totalGradePointArray,  $semesterTotalGradePoint);
            @endphp
            
            <div class="table-responsive mt-2">

                <div class="text-center mb-3"> 
                    <span style="font-size: 20px;"> <strong>{{ $semester->session }}  {{ $semester->semester_name }} </strong> </span> 
                </div>
                


                        

                        @if (count($semesterResults) > 0)

                            <table id="departments" class="table table-bordered">
                                <thead>
                                    {{-- <tr>
                                        
                                        <th colspan="2">Title of Course</th>
                                        <th colspan="2">Option</th>
                                        <th colspan="2">Grade</th>
                                    </tr> --}}
                                    <tr>
                                    <th scope="col">Course <br> Code</th>
                                    <th scope="col">Title of Course</th>
                                    <th scope="col">Units</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">Total Grade <br> Points</th>
                                    <th scope="col">Cum <br> G.P.A</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    

                                    @foreach ($semesterResults as $semesterResult)


                                        <tr class="grade-result">
                                            <td scope="col">{{ $semesterResult->course_code }}</td>
                                            <td scope="col">
                                                {{ $semesterResult->course_name }}
                                            </td>
                                            <td scope="col">{{ $semesterResult->unit }}</td>
                                            <td scope="col">{{ $semesterResult->grade }}</td>
                                            <td scope="col">{{ $semesterResult->grade_point }}</td>
                                            <td scope="col"></td>
                                        </tr>
                                        
                                    @endforeach

                            

                                    <tr class="grade-display">
                                        <td scope="col"></td>
                                        <td scope="col" >
                                            
                                        </td>
                                        <td scope="col" cellpadding="20" > <strong> {{ $semesterTotalCourseUnit }}</strong> </td>
                                        <td scope="col" ></td>
                                        <td scope="col" > <strong> {{ $semesterTotalGradePoint }} </strong> </td>
                                        <td scope="col" >  <strong> {{  number_format(array_sum($totalGradePointArray) / array_sum($totalUnitArray), 2) }} </strong> </td>
                                    </tr>

                                </tbody>

                            </table>

                        @else

                            <div class=" text-center text-danger my-2"> 
                                <h5>No Result Compiled Result for this Semester </h5>
                            </div>
                        @endif

                  
            </div>
                        
                
        @endforeach
     @endif
</div>