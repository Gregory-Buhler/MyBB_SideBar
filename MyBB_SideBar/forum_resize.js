<script type="text/javascript">
  function addMainDiv(boardSide) {
    document.addEventListener('DOMContentLoaded', function() {
      var forum = document.getElementsByClassName("wrapper");
      console.log(forum);
      var forumWrapper = forum[3];
      forumWrapper.innerHTML = "<div id=\"main\">" + forumWrapper.innerHTML +  "</div>";
      resizeForum(boardSide);
    }, false);
  }

  function resizeForum(boardSide) {
    console.log(boardSide);
    var main = document.getElementById("main");
    main.style.width = "80%";
  }
</script>
