function animationLogo2() {
    const textContainer = document.getElementById('text-container2');
    textContainer.innerHTML = ''; // Очищаем содержимое контейнера
    setTimeout(function () {
        const text = `const SlattInfo = {
            name: "Suren",
            age: 19,
            location: "Moscow",
            occupation: "Student",
            skills: ("PHP", "JavaScript", "HTML", "CSS")
            secondory skills: ("Next.js", "React")
            };
            ______
            |      
            | insanepage <3
            |______
            `;
        const textLines = text.split('\n'); // Разбиваем текст на строки
        const textContainer = document.getElementById('text-container2');
        let index = 0;

        function typeWriter() {
            if (index < textLines.length) { // Используем количество строк вместо общей длины текста
                const line = textLines[index];
                let lineIndex = 0;

                function typeLine() {
                    if (!isModalVisible) {
                        return; // Если модальное окно не видимо, прекращаем выполнение
                    } else {
                        if (lineIndex < line.length) {
                            textContainer.innerHTML += line.charAt(lineIndex);
                            lineIndex++;
                            setTimeout(typeLine, 35);
                        } else {
                            textContainer.innerHTML += '<br>&nbsp;&nbsp;&nbsp;&nbsp;'; // Добавляем перенос строки
                            index++;
                            setTimeout(typeWriter, 35);
                        }
                    }
                }

                typeLine();
            }
        }

        typeWriter();
    }, 100);
}

let isModalVisible = true; // Переменная для отслеживания видимости модального окна
// Обработчик события, вызываемый при закрытии модального окна
function handleModalClose() {
    isModalVisible = false;
}

// Обработчик события, вызываемый при открытии модального окна
function handleModalOpen() {
    isModalVisible = true;
}
