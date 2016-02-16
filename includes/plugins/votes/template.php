<? 
  //Оформление ответов в форме голосования
  $answer = '<tr><td><input type="radio" name="answer" value="{VALUE}"> {CAPTION}</td></tr>';
  
  //Форма голосования
  $general_template = '
  <form name="voting" action="?action=votes" method="POST">
   <center>
     {QUESTION}<br><br>
     <table border=0>
      {ANSWERS}
     </table><br>
     <input type="hidden" name="number" value="{VOTENUMBER}">
     <input type="submit" name="submit" value="Голосовать">
   </center>
  </form>';
  
  //Оформление ответов при показе результатов голосования
  $answer_for_already_vote = '<tr><td>{ANSWER}:</td><td>{COUNT}</td></tr>';
  
  //Результаты голосования
  $already_vote = '
    <center>
     {QUESTION}<br><br>
     <table border=0>
     {ANSWERS}
     </table>
    </center>';
  
?>