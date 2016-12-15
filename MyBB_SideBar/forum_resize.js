<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var forum = document.getElementsByClassName("wrapper");
    console.log(forum);
    var forumWrapper = forum[3];
    forumWrapper.innerHTML = "<div id=\"main\">" + forumWrapper.innerHTML +  "</div>";
    var main = document.getElementById("main");
    main.style.width = "80%";
  }, false);
</script>
