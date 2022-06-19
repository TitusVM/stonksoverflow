    </body>
    <script>
        function burgerMenu() {
            var mobileNavBar = document.getElementById('mobile-nav-bar');
            if (mobileNavBar.style.display === "block") {
                mobileNavBar.style.display = "none";
            } else {
                mobileNavBar.style.display = "block";
            }
        }

        setTimeout(function() {
            $('#messageDiv').fadeOut('fast');
        }, 1000); // <-- time in milliseconds

        function toggleAddCommentsAnswer(id)
        {
            let answerField = "#addCommentAnswer" + id;
            console.log(answerField);
            $(answerField).toggle("visibility");
        }

        function toggleAddAnswers(id) {
            let answerField = "#addAnswer" + id;
            console.log(answerField);
            $(answerField).toggle("visibility");
        }

        function toggleAddComments(id) {
            let commentField = "#addComment" + id;
            console.log(commentField);
            $(commentField).toggle("visibility");
        }

        function showQuestionDiv(id) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("questionDisplay").innerHTML =
                this.responseText;
            }
            xhttp.open("GET", "question?" + id);
            xhttp.send(); 

            var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

            if (width <= 640) {
                var questionDisplay = document.getElementById("questionDisplay");
                questionDisplay.style.display = "block";

                var questions = document.getElementById("questions");
                questions.style.display = "none";
            }
        }
    </script>
</html>
