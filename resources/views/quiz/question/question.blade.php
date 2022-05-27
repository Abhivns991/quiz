<style>
    .error{color:#bc0808; font-size:16px;}
    hr {
    margin-top: 0px;
    margin-bottom: 10px;
    border: 0;
    border-top: 1px solid #bc0808;
}
.sub {
        font-weight: 600;font-size: 14px !important;padding: 6px;background-color: #bc0808;color: white;border-radius: 8px;
    }
</style>
@foreach ($questions as $key => $question)
    <div class="quest_img">
      
        <span>Q. {{ $question['id'] }}</span>  <span class="sub" style="float: right;">{{ $question['subject'] }}</span><br>
        <hr>
            <img src="../../../images/questions/{{$question['question_img']}}" class="w-100"
            alt=""><br><br>
    </div>
    <form class="myform1" id="options">
        <input type="hidden" id="question_awn" name="question_id" value="{{$question['id']}}">
        <input type="hidden" id="topic_awn" name="topic_id" value="{{$topic->id}}">
        <input type="hidden" id="answer_awn" name="answer" value="{{$question['answer']}}">
      
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
        <span id="spnError" class="error" style="display: none"> Please select answer </span>
        <br>
        <div id="verifiBtn">
            @if ($questions->currentPage() == $questions->lastPage())
                <a class="btn col-auto btn-wave" href="#" onclick="final_submit()">Submit <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            @else
                <a onclick="next_question()" id ="btnSubmit" href="#" class="btn col-auto btn-wave">Next</a>
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
                    var url ="{{route('answer.quiz.index')}}";
                    url: url,
                            type: 'post',
                            var question_id = document.getElementById("question_awn").value;
                            var topic_id = document.getElementById("topic_awn").value;
                            var answer = document.getElementById("answer_awn").value;
                             data: {question_id: question_id,topic_id:topic_id,answer:answer},
                            dataType: 'json',
                            

      success: function(response){    
//respsonce
console.log(topic_id);
}
                })
        $('#question_div').html(data);
            },
        });
    }
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        $("#btnSubmit").click(function () {
            var isValid = $("input[name=radio]").is(":checked");
 
            //Display error message if no RadioButton is checked.
            $("#spnError")[0].style.display = isValid ? "none" : "block";
        });
    });
</script>