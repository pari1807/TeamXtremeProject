// Get quiz score from localStorage
document.addEventListener('DOMContentLoaded', () => {
    const quizScore = localStorage.getItem('quizScore') || 0;
    document.getElementById('quizScore').textContent = quizScore;

    // Initialize charts
    initCharts();

    // Add animation to score element
    animateScore();
});

// Animate Score
function animateScore() {
    const scoreElement = document.getElementById('quizScore');
    scoreElement.style.opacity = '0';
    scoreElement.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        scoreElement.style.transition = 'all 1s ease';
        scoreElement.style.opacity = '1';
        scoreElement.style.transform = 'translateY(0)';
    }, 300);
}

// Initialize Charts
function initCharts() {
    // Chart.js global settings
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size = 14;
    Chart.defaults.animation.duration = 2000;
    Chart.defaults.animation.easing = 'easeOutQuart';
    Chart.defaults.plugins.tooltip.padding = 12;
    Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(30, 41, 59, 0.8)';
    Chart.defaults.plugins.tooltip.titleFont = { size: 14, weight: 'bold' };
    Chart.defaults.plugins.tooltip.bodyFont = { size: 13 };
    Chart.defaults.plugins.tooltip.cornerRadius = 8;
    
    // Assignment Completion Chart (Pie)
    const completionCtx = document.getElementById('completionChart').getContext('2d');
    new Chart(completionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'In Progress', 'Not Started'],
            datasets: [{
                data: [65, 25, 10],
                backgroundColor: [
                    '#8B5CF6',
                    '#C084FC',
                    '#E9D5FF'
                ],
                borderWidth: 0,
                borderRadius: 4,
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}%`;
                        }
                    }
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });

    // Subject-wise Performance Chart (Bar)
    const subjectCtx = document.getElementById('subjectChart').getContext('2d');
    new Chart(subjectCtx, {
        type: 'bar',
        data: {
            labels: ['Math', 'Science', 'History', 'English'],
            datasets: [{
                label: 'Scores',
                data: [85, 75, 65, 80],
                backgroundColor: [
                    '#8B5CF6',
                    '#EC4899',
                    '#3B82F6',
                    '#F97316'
                ],
                borderRadius: 8,
                barThickness: 40,
                maxBarThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: 'rgba(200, 200, 200, 0.15)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: 'rgba(100, 116, 139, 0.8)'
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: 'rgba(100, 116, 139, 0.8)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Score: ${context.raw}/100`;
                        }
                    }
                }
            },
            animation: {
                delay: (context) => context.dataIndex * 200
            }
        }
    });

    // Score Trend Chart (Line)
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    
    // Create gradient for line background
    const gradient = trendCtx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(147, 51, 234, 0.5)');
    gradient.addColorStop(0.5, 'rgba(147, 51, 234, 0.25)');
    gradient.addColorStop(1, 'rgba(147, 51, 234, 0)');
    
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
            datasets: [{
                label: 'Average Score',
                data: [65, 70, 75, 80, 85, 88],
                borderColor: '#9333EA',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#9333EA',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        display: true,
                        drawBorder: false,
                        color: 'rgba(200, 200, 200, 0.15)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: 'rgba(100, 116, 139, 0.8)',
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: 'rgba(100, 116, 139, 0.8)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Score: ${context.raw}%`;
                        }
                    }
                }
            },
            interaction: {
                mode: 'index',
                intersect: false
            },
            animation: {
                x: {
                    type: 'number',
                    easing: 'easeOutQuart',
                    duration: 2000,
                    from: NaN, // the point is initially skipped
                    delay(ctx) {
                        if (ctx.type !== 'data' || ctx.xStarted) {
                            return 0;
                        }
                        ctx.xStarted = true;
                        return ctx.index * 100;
                    }
                },
                y: {
                    type: 'number',
                    easing: 'easeOutQuart',
                    duration: 2000,
                    from: 0,
                    delay(ctx) {
                        if (ctx.type !== 'data' || ctx.yStarted) {
                            return 0;
                        }
                        ctx.yStarted = true;
                        return ctx.index * 100;
                    }
                }
            }
        }
    });

    // Assignment Score Chart (Polar Area)
    const assignmentScoreCtx = document.getElementById('assignmentScoreChart').getContext('2d');
    new Chart(assignmentScoreCtx, {
        type: 'polarArea',
        data: {
            labels: ['Assignment 1', 'Assignment 2', 'Assignment 3', 'Assignment 4', 'Assignment 5'],
            datasets: [{
                label: 'Assignment Scores',
                data: [70, 85, 60, 90, 75],
                backgroundColor: [
                    '#8B5CF6',
                    '#EC4899',
                    '#3B82F6',
                    '#F97316',
                    '#22D3EE'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Student Improvements Chart (Radar)
    const improvementsCtx = document.getElementById('improvementsChart').getContext('2d');
    new Chart(improvementsCtx, {
        type: 'radar',
        data: {
            labels: ['Speed', 'Accuracy', 'Consistency', 'Participation', 'Creativity'],
            datasets: [{
                label: 'Improvements',
                data: [80, 70, 85, 60, 75],
                backgroundColor: 'rgba(139, 92, 246, 0.2)',
                borderColor: '#8B5CF6',
                pointBackgroundColor: '#8B5CF6',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#8B5CF6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart',
                delay: (context) => context.dataIndex * 200
            },
            scales: {
                r: {
                    angleLines: { color: 'rgba(200,200,200,0.15)' },
                    grid: { color: 'rgba(200,200,200,0.15)' },
                    pointLabels: {
                        font: { size: 13 },
                        color: 'rgba(100,116,139,0.8)'
                    },
                    ticks: {
                        font: { size: 12 },
                        color: 'rgba(100,116,139,0.8)'
                    }
                }
            }
        }
    });

    // Assigning Questions/Problems Chart (Radar)
    const questionsCtx = document.getElementById('questionsChart').getContext('2d');
    new Chart(questionsCtx, {
        type: 'radar',
        data: {
            labels: ['Math', 'Science', 'History', 'English', 'Logic'],
            datasets: [{
                label: 'Assigned Problems',
                data: [6, 8, 5, 7, 9],
                backgroundColor: 'rgba(236, 72, 153, 0.2)',
                borderColor: '#EC4899',
                pointBackgroundColor: '#EC4899',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#EC4899'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart',
                delay: (context) => context.dataIndex * 200
            },
            scales: {
                r: {
                    angleLines: { color: 'rgba(200,200,200,0.15)' },
                    grid: { color: 'rgba(200,200,200,0.15)' },
                    pointLabels: {
                        font: { size: 13 },
                        color: 'rgba(100,116,139,0.8)'
                    },
                    ticks: {
                        font: { size: 12 },
                        color: 'rgba(100,116,139,0.8)'
                    }
                }
            }
        }
    });
}