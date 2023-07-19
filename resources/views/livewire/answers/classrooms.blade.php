<div>
    {{-- classroom list  --}}
    <div class="container card card-body">
        <div class="row">
            <h4>Quiz List:</h4>
            @foreach ($classrooms as $quiz)
            @foreach ($quiz->quizzes as $item)
            <div class="col-md-4">
                @if ($item->answers->count() > 0)
                <div class="card shadow">
                    <a href="{{ asset('quizDetail/'.$item->id.'/'.$student_id) }}" class="text-decoration-none">
                        <img class="card-img-top" src="{{ asset('quiz.jpg') }}" alt="">
                    </a>
                    <div class="card-body">
                        <a href="{{ asset('quizDetail/'.$item->id.'/'.$student_id) }}" class="text-decoration-none">
                            <h4 class="card-title">{{$item->quiz_name}}</h4>
                        </a>
                        <p class="card-text">Per question mark:{{$item->per_question_mark}}</p>
                    </div>
                </div>
                @endif
            </div>
            @endforeach

            @endforeach
        </div>
    </div>

</div>
</div>
