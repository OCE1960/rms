<div class="col-12">
                    @if (isset($academicResults) && count($academicResults) > 0)

                        
                        @php
                            $x = 0;
                            $totalUnitArray = [];
                            $totalGradePointArray = [];
                        @endphp

                        @foreach($academicResults as $semesterId => $semesterResults)

                        @php
                            $semester = $semesterResults[0]->semester;
                            $semesterTotalCourseUnit = $semester->studentSemesterTotalCourseUnit($userRequestingTranscript->id);
                            $semesterTotalGradePoint = $semester->studentSemesterTotalGradePoint($userRequestingTranscript->id);
                            array_push($totalUnitArray, $semesterTotalCourseUnit);
                            array_push($totalGradePointArray,  $semesterTotalGradePoint);
                        @endphp

                            <div class="table-responsive mt-2">

                                <div class="text-center mb-3"> 
                                    <span style="font-size: 20px;"> <strong>{{ $semester->semester_session }}  {{ $semester->semester_name }} </strong> </span> 
                                     
                                </div>

                                        @if (count($semesterResults) > 0)

                                            <table id="departments" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">Course <br> Code</th>
                                                    <th scope="col">Title of Course</th>
                                                    <th scope="col">Units</th>
                                                    <th scope="col">Score</th>
                                                    <th scope="col">Grade</th>
                                                    <th scope="col">Total Grade <br> Points</th>
                                                    <th scope="col">Cum <br> G.P.A</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($semesterResults as $academicResult)
                                                        @php
                                                            
                                                        @endphp

                                                        <tr class="grade-result">
                                                            <td scope="col">{{ $academicResult->course->course_code }}</td>
                                                            <td scope="col">
                                                                {{ $academicResult->course->course_name }} <br/>  
                                                            </td>
                                                            
                                                            <td scope="col">{{ $academicResult->unit }}</td>
                                                            <td scope="col">{{ $academicResult->score }}</td>
                                                            <td scope="col">{{ $academicResult->grade }}</td>
                                                            <td scope="col">{{ $academicResult->grade_point }}</td>
                                                            <td scope="col"></td>
                                                        </tr>
                                                        
                                                    @endforeach

                                            

                                                    <tr class="grade-display">
                                                        <td></td>
                                                        <td></td>
                                                        <td> <strong> {{ $semesterTotalCourseUnit }}</strong> </td>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td> <strong> {{ $semesterTotalGradePoint }} </strong> </td>
                                                        <td>  <strong> {{  number_format(array_sum($totalGradePointArray) / array_sum($totalUnitArray), 2) }} </strong> </td>
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