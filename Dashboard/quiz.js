// Quiz Questions
const questions = [
    // Mentally Analytical Questions (for fast learners)
    {
        question: "If 3x + 2 = 11, what is the value of x?",
        options: ["2", "3", "4", "5"],
        correctAnswer: "3"
    },
    {
        question: "Which number comes next in the sequence: 2, 4, 8, 16, ?",
        options: ["18", "24", "32", "20"],
        correctAnswer: "32"
    },
    {
        question: "If a train travels 60 km in 1.5 hours, what is its average speed?",
        options: ["30 km/h", "40 km/h", "45 km/h", "50 km/h"],
        correctAnswer: "40 km/h"
    },
    {
        question: "Which shape has the most sides?",
        options: ["Triangle", "Hexagon", "Pentagon", "Octagon"],
        correctAnswer: "Octagon"
    },
    {
        question: "What is the value of 7 squared?",
        options: ["14", "49", "21", "28"],
        correctAnswer: "49"
    },
    // General Knowledge/Basic Questions (for slow learners)
    {
        question: "What is the capital of France?",
        options: ["London", "Berlin", "Paris", "Madrid"],
        correctAnswer: "Paris"
    },
    {
        question: "Which planet is known as the Red Planet?",
        options: ["Venus", "Mars", "Jupiter", "Saturn"],
        correctAnswer: "Mars"
    },
    {
        question: "What is the largest mammal in the world?",
        options: ["Elephant", "Blue Whale", "Giraffe", "Polar Bear"],
        correctAnswer: "Blue Whale"
    },
    {
        question: "Which animal is known as the King of the Jungle?",
        options: ["Tiger", "Lion", "Elephant", "Leopard"],
        correctAnswer: "Lion"
    },
    {
        question: "How many days are there in a week?",
        options: ["5", "6", "7", "8"],
        correctAnswer: "7"
    }
];

// Shuffle questions randomly
function shuffleQuestions(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
}

shuffleQuestions(questions);

let currentQuestion = 0;
let score = 0;
let timer;
let timeLeft = 30;
let quizStarted = false;

// Initialize Quiz
function initQuiz() {
    const startQuizBtn = document.getElementById('startQuizBtn');
    const submitBtn = document.getElementById('submitBtn');
    const progressContainer = document.getElementById('progressContainer');

    startQuizBtn.addEventListener('click', () => {
        quizStarted = true;
        startQuizBtn.classList.add('hidden');
        submitBtn.classList.remove('hidden');
        progressContainer.classList.remove('hidden');
        displayQuestion();
        startTimer();
    });
}

// Display Question
function displayQuestion() {
    const quizContainer = document.getElementById('quizContainer');
    quizContainer.innerHTML = '';

    const question = questions[currentQuestion];
    const card = document.createElement('div');
    card.className = 'quiz-card rounded-2xl shadow-xl p-8 w-full max-w-xl mx-auto text-center';
    card.innerHTML = `
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Question ${currentQuestion + 1}</h2>
            <div class="timer font-bold">${timeLeft}s</div>
        </div>
        <p class="text-gray-700 mb-8 text-xl">${question.question}</p>
        <div class="space-y-4">
            ${question.options.map((option, index) => `
                <div class="option p-4 border-2 rounded-xl cursor-pointer hover:bg-purple-50 transition-all relative" 
                     onclick="selectOption(this, '${option}')">
                    <div class="grid grid-cols-12 items-center">
                        <div class="col-span-2 flex justify-start">
                            <span class="w-8 h-8 flex items-center justify-center border-2 border-purple-600 rounded-full font-medium text-purple-600">
                                ${String.fromCharCode(65 + index)}
                            </span>
                        </div>
                        <div class="col-span-10 text-center">
                            ${option}
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
    `;

    quizContainer.appendChild(card);
    updateProgress();
}

// Select Option
function selectOption(element, selectedAnswer) {
    if (!quizStarted) return;

    // Remove previous selection
    document.querySelectorAll('.option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    // Add selection to clicked option
    element.classList.add('selected');
    
    // Check answer after a delay
    setTimeout(() => {
        checkAnswer(selectedAnswer);
    }, 500);
}

// Check Answer
function checkAnswer(selectedAnswer) {
    const correctAnswer = questions[currentQuestion].correctAnswer;
    if (selectedAnswer === correctAnswer) {
        score += 10;
        document.getElementById('score').textContent = score;
    }
    
    // Move to next question
    currentQuestion++;
    if (currentQuestion < questions.length) {
        resetTimer();
        displayQuestion();
    } else {
        endQuiz();
    }
}

// Timer Functions
function startTimer() {
    timer = setInterval(() => {
        timeLeft--;
        const timerElement = document.querySelector('.timer');
        if (timerElement) {
            timerElement.textContent = `${timeLeft}s`;
        }
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            currentQuestion++;
            if (currentQuestion < questions.length) {
                resetTimer();
                displayQuestion();
            } else {
                endQuiz();
            }
        }
    }, 1000);
}

function resetTimer() {
    clearInterval(timer);
    timeLeft = 30;
    startTimer();
}

// Update Progress
function updateProgress() {
    const progress = ((currentQuestion + 1) / questions.length) * 100;
    document.getElementById('progressBar').style.width = `${progress}%`;
}

// End Quiz
function endQuiz() {
    clearInterval(timer);
    localStorage.setItem('quizScore', score);
    window.location.href = 'analysis.html';
}

// Initialize quiz when page loads
document.addEventListener('DOMContentLoaded', initQuiz);

// Submit Button Event
document.getElementById('submitBtn').addEventListener('click', () => {
    endQuiz();
});