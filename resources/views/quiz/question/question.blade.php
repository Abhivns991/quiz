@foreach ($questions as $key => $question)
    <div class="quest_img">
        <span>Subject. {{ $question['subject'] }}</span><br>
        <span>Q. {{ $question['id'] }}</span> <br>
        <img src="../../../images/questions/{{$question['question_img']}}" class="w-100"
            alt=""><br><br>
    </div>
    <form class="myform1" id="options">
        <input type="hidden" name="question_id" value="{{$question->id}}">
        <input type="hidden" name="topic_id" value="{{$topic->id}}">
        <input type="hidden" name="answer" value="{{$question->answer}}">
      
        <label class="options">A
            <input type="radio" name="radio">
            <span class="checkmark"></span>
        </label>
        <label class="options">B
            <input type="radio" name="radio">
            <span class="checkmark"></span>
        </label>
        <label class="options">C
            <input type="radio" name="radio">
            <span class="checkmark"></span>
        </label>
        <label class="options">D
            <input type="radio" name="radio">
            <span class="checkmark"></span>
        </label>
        <br>
        <div id="verifiBtn">
            @if ($questions->currentPage() == $questions->lastPage())
                <a class="btn col-auto btn-wave" href="#" onclick="final_submit()">Submit <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            @else
                <a onclick="next_question()" href="#" class="btn col-auto btn-wave">Next</a>
            @endif
        </div>
    </form>
@endforeach

{{-- href="{{asset('start-quiz-index/'.$topic->id.$questions->url($questions->currentPage()+1))}}" --}}

<script>
    function next_question() {
        $.ajax({
            url: "{{ asset('start-quiz-index/' . $topic->id . $questions->url($questions->currentPage() + 1)) }}",
            success: function(data) {
                $.ajax({
                    url: url,
                            type: 'post',
                            var id = 
                            data: {rr: id,hhkj:jf},
                            dataType: 'json',

      success: function(response){
//responces
}
                })
                console.log(data);
                $('#question_div').html(data);
            },
        });
    }
</script>
