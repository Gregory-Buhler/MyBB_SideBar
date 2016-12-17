<script type="text/javascript">
  function addMainDiv(boardSide) {
    document.addEventListener('DOMContentLoaded', function() {
      var forum = document.getElementsByClassName("wrapper");
      console.log(forum);
      var forumWrapper = forum[3];
      forumWrapper.innerHTML = "<div id=\"main\">" + forumWrapper.innerHTML +  "</div>";
      resizeForum(boardSide, forumWrapper);
    }, false);
  }

  function resizeForum(boardSide, wrapper) {
    console.log(boardSide);
    var main = document.getElementById("main");
    if (boardSide == 1) {
      main.style.width = "80%";
      main.style.float = "left";
      wrapper.innerHTML = wrapper.innerHTML + "<div class=\"sideBar sideBarRight\">Test</div>";
    }
    if (boardSide == 2) {
      main.style.width = "80%";
      main.style.float = "right";
      wrapper.innerHTML = "<div class=\"sideBar sideBarLeft\">Test</div>" + wrapper.innerHTML;
    }
    if (boardSide == 3) {
      main.style.width = "60%";
      main.style.float = "left";
      wrapper.innerHTML = "<div class=\"sideBar sideBarLeft\">Test</div>" + wrapper.innerHTML + "<div class=\"sideBar sideBarRight\">Test</div>";
    }
  }
</script>
