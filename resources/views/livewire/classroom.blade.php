<div>
    <div class="row">
        <h4>Classroom name: {{$classroom->classroom_name}}</h4>
        @foreach ($classroom->quizzes as $item)
        <div class="col-md-4">
            <div class="card text-left mt-4 shadow">
                <a href="{{ asset('classroom/'.$item->id.'/quiz') }}" class="text-decoration-none">
                    <img class="card-img-top" src="{{ asset('quiz.jpg') }}" alt="">
                </a>
                <div class="card-body">
                    <a href="{{ asset('classroom/'.$item->id.'/quiz') }}" class="text-decoration-none">
                        <h4 class="card-title">{{$item->quiz_name}}</h4>
                    </a>
                    <p class="card-text">Per question mark:{{$item->per_question_mark}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
