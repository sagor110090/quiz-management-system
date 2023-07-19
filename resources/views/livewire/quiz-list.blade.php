<div class="bg-white p-3">
    <h4>Quiz Name: {{$quiz->quiz_name}}</h4>
    <p>Per question mark: {{$quiz->per_question_mark}}</p>
    <p>Total marks: {{$quiz->per_question_mark * $quiz->questions->count()}}</p>
    @if ($answers->count() > 0)
    <p>Total marks obtained: {{$answers->sum('mark')}}</p>
    <h5>Multiple choice:</h5>
        <table class="table table-striped shadow p-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Correct ans</th>
                    <th>Mark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers->where('long_question_answer',null)->where('missing_word',0) as $answer)
                    <tr>
                        <td>{{$loop->iteration}}.</td>
                        <td>{{Str::limit($answer->question, 100, '...')}}</td>
                        <td>{{$answer->short_question_answer}}</td>
                        <td>{{$answer->short_question_correct}}</td>
                        <td>{{$answer->mark}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <h5>Missing word questions:</h5>
        <table class="table table-striped shadow p-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Correct ans</th>
                    <th>Mark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers->where('missing_word',1) as $answer)
                    <tr>
                        <td>{{$loop->iteration}}.</td>
                        <td>{{Str::limit($answer->question, 100, '...')}}</td>
                        <td>{{$answer->short_question_answer}}</td>
                        <td>{{$answer->short_question_correct}}</td>
                        <td>{{$answer->mark}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <h5>Long written answers:</h5>
        <table class="table table-striped shadow p-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Mark</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers->where('long_question_answer','!=',null) as $answer)
                    <tr>
                        <td>{{$loop->iteration}}.</td>
                        <td>{{Str::limit($answer->question, 100, '...')}}</td>
                        <td>{{$answer->long_question_answer}}</td>
                        <td>{{$answer->mark}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
    @if ($quiz->questions->count() > 0)
    <form method="POST" action="{{ asset('/classroom/'.$quiz->id.'/quiz') }}">
        {{ csrf_field() }}

        @php
            $i = 0;
        @endphp

        @foreach ($quiz->questions->where('long_written',0)->where('missing_word',0) as $questions)

            @php
                $q=0;
            @endphp

            <div class="mt-3 bg-white p-3">
                @if (!$questions->long_written)
                <p>Q {{$loop->iteration}}. - {{$questions->question}}</p>
                @if ($questions->image)
                <img src="{{Storage::url($questions->image)}}" height="200px" width="300px" class="m-3" alt="">

                @endif
                <input type="hidden" name="question[]" id="" value="{{$questions->question}}">
                <input type="hidden" name="short_question_correct[]" id="" value="{{$questions->answer}}">
                <input type="hidden" name="missing_word[]" id="" value="0">
                @foreach ($questions->questionOptions as $questionOptions)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="short_question_answer[{{$i}}][0]"   value="{{$questionOptions->option_name}}">
                    <label class="form-check-label">
                        {{$questionOptions->option_name}}
                    </label>
                </div>
                @php
                    $q++;
                @endphp
                @endforeach


                @endif

            </div>

            @php
                $i++;
            @endphp

        @endforeach
        @foreach ($quiz->questions->where('missing_word',1) as $questions)

            @php
                $q=0;
            @endphp

            <div class="mt-3 bg-white p-3">
                @if ($questions->missing_word)

                <p>Q {{$loop->iteration}}. - {{$questions->question}}</p>
                <input type="hidden" name="question[]" id="" value="{{$questions->question}}">
                @if ($questions->image)
                <img src="{{Storage::url($questions->image)}}" height="200px" width="300px" class="m-3" alt="">

                @endif
                <div class="form-group">
                <label for="answer">Answer</label>
                <input type="text" class="form-control" name="short_question_answer[{{$i}}][0]" id="answer">
                <input type="hidden" name="short_question_correct[]" id="" value="{{$questions->answer}}">
                <input type="hidden" name="missing_word[]" id="" value="1">

                </div>

                @endif

            </div>

            @php
                $i++;
            @endphp

        @endforeach
        @foreach ($quiz->questions->where('long_written',1) as $questions)

            @php
                $q=0;
            @endphp

            <div class="mt-3 bg-white p-3">
                @if ($questions->long_written)
                <p>Q {{$loop->iteration}}. - {{$questions->question}}</p>
                {{-- image --}}
                @if ($questions->image)
                <img src="{{Storage::url($questions->image)}}" height="200px" width="300px" class="m-3" alt="">

                @endif
                <input type="hidden" name="long_question[]" id="" value="{{$questions->question}}">
                <div class="form-group">
                <label for="answer">Answer</label>
                <textarea class="form-control" name="long_question_answer[]" id="answer" rows="3"></textarea>
                </div>

                @endif

            </div>

            @php
                $i++;
            @endphp

        @endforeach
        <button type="submit" class="btn btn-success mt-3">Submit</button>


    </form>
    @else
    <p class="text-danger text-center mt-5">No questions in this quiz</p>
    @endif

    @endif

</div>
