<div class="shadow p-3 bg-white rounded">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-transcript-request-tab" data-toggle="tab" data-target="#nav-transcript-request" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Transcript Requests</button>
            <button class="nav-link" id="nav-academic-results-tab" data-toggle="tab" data-target="#nav-academic-results" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Academic Results</button>
    
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-transcript-request" role="tabpanel" aria-labelledby="nav-transcript-request-tab">

            @include('transcript-requests.partials.list')

        </div>

        <div class="tab-pane fade" id="nav-academic-results" role="tabpanel" aria-labelledby="nav-academic-results-tab">
            @include('tasks.partials.list-academic-results')
        </div>
    </div>

</div>