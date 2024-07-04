const question = document.getElementById("question");
const choices = Array.from(document.getElementsByClassName("choice-text"));
const prgroessText = document.getElementById("progressText");
const scoreText = document.getElementById("score");
const progressBarComplete = document.getElementById("progressBarComplete");
let currentQuestion = {};
let acceptingAnswers = true;
let score = 0;
let questionCounter = 0;
let availableQuestions = [];

let qustions= [
    {
        question:"In the early 1900s which ones of these were not an option to transport children?? ",
        choice1: "Boat" ,
        choice2: "By foot" ,
        choice3: "Plane" ,
        choice4: "Post" ,
        answer: 3


    },
    {
        question:"What is the capital of Brazil?",
        choice1: "Rio" ,
        choice2: "Cancun" ,
        choice3: "Brasilia" ,
        choice4: "Amazon" ,
        answer: 3


    },
    {
        question:"What year did WW2 end?",
        choice1: "1919" ,
        choice2: "2001" ,
        choice3: "1932" ,
        choice4: "1945" ,
        answer: 4


    },
    {
        question:"What PH level is classed as neutral?",
        choice1: "PH 1" ,
        choice2: "PH 7" ,
        choice3: "PH 9" ,
        choice4: "Ph 5" ,
        answer: 2


    },

    {
      question:"On what continent can Peru be found?",
      choice1: "Europe" ,
      choice2: "Asia" ,
      choice3: "North America" ,
      choice4: "South America" ,
      answer: 4


  },

]

const CORRECT_BONUS = 10;
const MAX_QUESTIONS = 5;

startGame = () => {
    questionCounter= 0;
    score= 0;
    availableQuestions = [...qustions];
    console.log(availableQuestions);
    getNewQuestion();
};


getNewQuestion = () => {
    if (availableQuestions.length === 0 || questionCounter >= MAX_QUESTIONS) {
      localStorage.setItem("mostRecentScore", score);

        //go to the end page
        return window.location.assign("end.html");
      }
    questionCounter++;
   progressText.innerText = `Question ${questionCounter}/${MAX_QUESTIONS}`;
      progressBarComplete.style.width = `${(questionCounter / MAX_QUESTIONS) * 100}%`;

   const questionIndex = Math.floor(Math.random() * availableQuestions.length);
   currentQuestion=availableQuestions[questionIndex];
   question.innerText = currentQuestion.question;
   
   
   choices.forEach(choice => {
    const number = choice.dataset["number"];
    choice.innerText = currentQuestion["choice" + number];
  });

  availableQuestions.splice(questionIndex, 1);
  acceptingAnswers = true;
};

choices.forEach(choice => {
  choice.addEventListener("click", e => {
    if (!acceptingAnswers) return;

    acceptingAnswers = false;
    const selectedChoice = e.target;
    const selectedAnswer = selectedChoice.dataset["number"];

    const classToApply =
      selectedAnswer == currentQuestion.answer ? "correct" : "incorrect";

    if (classToApply === "correct") {
        incrementScore(CORRECT_BONUS);
    }

    selectedChoice.parentElement.classList.add(classToApply);

    setTimeout(() => {
      selectedChoice.parentElement.classList.remove(classToApply);
      getNewQuestion();
    }, 1000);
  });
});

incrementScore = num => {
    score += num;
    scoreText.innerText = score;
};

startGame();










