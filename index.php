<!DOCTYPE html> <html> <head> <title>Форма фильтрации данных</title> </head> <body> <form id="filterForm"> <label for="startDate">Дата начала:</label> <input type="date" id="startDate" name="startDate">
<label for="endDate">Дата конца:</label> 
<input type="date" id="endDate" name="endDate"> <button type="submit">Запустить</button>
</form> <table id="table1"> 
<!-- Таблица для отображения результатов фильтрации по операторам и подсчета повторных значений --> <thead> <tr> <th onclick="sortTable(table1, 0)">Оператор</th> <th onclick="sortTable(table1, 
1)">AON_2</th> <th onclick="sortTable(table1, 
2)">Процент повторных значений</th> </tr> </thead> <tbody id="tableBody1"></tbody> </table> <table id="table2"> <!-- Таблица для отображения результатов фильтрации по результату звонка "Срыв/сбой звонка" --> <thead> <tr> <th onclick="sortTable(table2, 0)">Оператор</th> <th onclick="sortTable(table2,
1)">Результат звонка</th> <th onclick="sortTable(table2, 
2)">Количество обращений</th> </tr> </thead> <tbody id="tableBody2"></tbody> </table> <table id="table3"> <!-- Таблица для отображения среднего значения времени "HOLD TIME, сек" --> <thead> <tr> <th onclick="sortTable(table3, 0)">Оператор</th> <th onclick="sortTable(table3, 1)">Среднее время HOLD TIME, сек</th> </tr> </thead> <tbody id="tableBody3"></tbody> </table> <table id="table4"> <!-- Таблица для отображения количества входящих и исходящих звонков --> <thead> <tr> <th onclick="sortTable(table4, 0)">Оператор</th> <th onclick="sortTable(table4,
1)">Тип звонка</th> <th onclick="sortTable(table4,
2)">Количество звонков</th> </tr> </thead> <tbody id="tableBody4"></tbody> </table>
<script src="script.js"></script>
</body> </html>
/* CSS стили для таблицы */ table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid #ddd; padding: 8px; text-align: left; } th { cursor: pointer; }
JavaScript: // JavaScript код для обработки формы фильтрации данных и отображения результатов в таблицах // Обработчик события отправки формы document.getElementById("filterForm").addEventListener("submit", function(event) { event.preventDefault();
// Получаем значения полей выбора дат var startDate = document.getElementById("startDate").value; var endDate = document.getElementById("endDate").value;
// Отправляем запрос на сервер с данными формы var xhr = new XMLHttpRequest(); xhr.open("POST", "filter.php", true); xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8"); xhr.onreadystatechange = function() { if (xhr.readyState === XMLHttpRequest.DONE) { if (xhr.status === 200) { // Получаем данные из ответа сервера var data = JSON.parse(xhr.responseText);
    // Отображаем результаты в таблицах
    displayTable1(data.table1); // Отображение данных в таблице 1
    displayTable2(data.table2); // Отображение данных в таблице 2
    displayTable3(data.table3); // Отображение данных в таблице 3
    displayTable4(data.table4); // Отображение данных в таблице 4
  } else {
    console.error("Ошибка запроса: " + xhr.statusText);
  }
}
};
 // Формируем данные для отправки на сервер var formData = new FormData(); formData.append("startDate", startDate); formData.append("endDate", endDate); xhr.send(formData);
});
// Функция отображения данных в таблице 2 function displayTable2(data) { // Очищаем таблицу var table = document.getElementById("table2"); table.innerHTML = "";
// Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Номер", "Количество повторений", "Процент повторных значений"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header);
// Отображаем данные в таблице for (var i = 0; i < data.length; i++) { var row = document.createElement("tr"); var cell1 = document.createElement("td"); var cell2 = document.createElement("td"); var cell3 = document.createElement("td"); cell1.textContent = data[i].number; cell2.textContent = data[i].count; cell3.textContent = data[i].percent; row.appendChild(cell1); row.appendChild(cell2); row.appendChild(cell3);
// Отображаем данные в таблице table.appendChild(row); } } // Функция отображения данных в таблице 3 function displayTable3(data) { // Очищаем таблицу var table = document.getElementById("table3"); table.innerHTML = ""; // Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Имя", "Фамилия", "Email"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header); // Отображаем данные в таблице for (var i = 0; i < data.length; i++) { var row = document.createElement("tr"); var cell1 = document.createElement("td"); var cell2 = document.createElement("td"); var cell3 = document.createElement("td"); cell1.textContent = data[i].firstName; cell2.textContent = data[i].lastName; cell3.textContent = data[i].email; row.appendChild(cell1); row.appendChild(cell2); row.appendChild(cell3); table.appendChild(row); } } // Функция отображения данных в таблице 4 function displayTable4(data) { // Очищаем таблицу var table = document.getElementById("table4"); table.innerHTML = ""; // Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Дата", "Время", "Тема"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header); // Отображаем данные в таблице for (var i = 0; i < data.length; i++) { var row = document.createElement("tr"); var cell1 = document.createElement("td"); var cell2 = document.createElement("td"); var cell3 = document.createElement("td"); cell1.textContent = data[i].date; cell2.textContent = data[i].time; cell3.textContent = data[i].topic; row.appendChild(cell1); row.appendChild(cell2); row.appendChild(cell3); table.appendChild(row); } }
// Функция сортировки таблицы по столбцу function sortTable(table, column) { var rows = table.rows; var switching = true; var shouldSwitch = false; var i, x, y; var direction = "asc"; while (switching) { switching = false; for (i = 1; i < (rows.length - 1); i++) { shouldSwitch = false; x = rows[i].getElementsByTagName("td")[column]; y = rows[i + 1].getElementsByTagName("td")[column]; if (direction == "asc") { if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) { shouldSwitch = true; break; } } else if (direction == "desc") { if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) { shouldSwitch = true; break; } } } if (shouldSwitch) { rows[i].parentNode.insertBefore(rows[i + 1], rows[i]); switching = true; } else { if (direction == "asc") { direction = "desc"; switching = true; } } } }
// Функция отображения данных в таблице 1 function displayTable1(data) { // Очищаем таблицу var table = document.getElementById("table1"); table.innerHTML = "";
// Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Оператор", "AON_2", "Процент повторных значений"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header);
// Отображаем данные в таблице for (var i = 0; i < data.length; i++) { var row = document.createElement("tr"); var cell1 = document.createElement("td"); var cell2 = document.createElement("td"); var cell3 = document.createElement("td"); cell1.textContent = data[i].operator; cell2.textContent = data[i].aon_2; cell3.textContent = data[i].percent; row.appendChild(cell1); row.appendChild(cell2); row.appendChild(cell3);
// Отображаем данные в таблице
table.appendChild(row);
} }
// Функция отображения данных в таблице 3 function displayTable3(data) { // Очищаем таблицу var table = document.getElementById("table3"); table.innerHTML = "";
// Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Оператор", "Среднее время HOLD TIME, сек"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header);
// Отображаем данные в таблице for (var i = 0; i < data.length; i++) { var row = document.createElement("tr"); var cell1 = document.createElement("td"); var cell2 = document.createElement("td"); cell1.textContent = data[i].operator; cell2.textContent = data[i].holdTime; row.appendChild(cell1); row.appendChild(cell2);
// Отображаем данные в таблице
table.appendChild(row);
} }
// Функция отображения данных в таблице 4 function displayTable4(data) { // Очищаем таблицу var table = document.getElementById("table4"); table.innerHTML = "";
// Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Оператор", "Тип звонка", "Количество звонков"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header);
// Отображаем данные в таблице for (var i = 0; i < data.length; i++) { var row = document.createElement("tr"); var cell1 = document.createElement("td"); var cell2 = document.createElement("td"); var cell3 = document.createElement("td"); cell1.textContent = data[i].operator; cell2.textContent = data[i].callType; cell3.textContent = data[i].count; row.appendChild(cell1); row.appendChild(cell2); row.appendChild(cell3);
// Отображаем данные в таблице
table.appendChild(row);
} }
// Функция сортировки таблицы по столбцу function sortTable(table, column) { var rows = table.rows; var switching = true; var shouldSwitch = false; var i, x, y; var direction = "asc"; while (switching) { switching = false; for (i = 1; i < (rows.length - 1); i++) { shouldSwitch = false; x = rows[i].getElementsByTagName("td")[column]; y = rows[i + 1].getElementsByTagName("td")[column]; if (direction == "asc") { if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) { shouldSwitch = true; break; } } else if (direction == "desc") { if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) { shouldSwitch = true; break; } } } if (shouldSwitch) { rows[i].parentNode.insertBefore(rows[i + 1], rows[i]); switching = true; } else { if (direction == "asc") { direction = "desc"; switching = true; } } } }
// JavaScript код для обработки формы фильтрации данных и отображения результатов в таблицах
// Обработчик события отправки формы document.getElementById("filterForm").addEventListener("submit", function(event) { event.preventDefault();
// Получаем значения полей выбора дат var startDate = document.getElementById("startDate").value; var endDate = document.getElementById("endDate").value;
// Отправляем запрос на сервер с данными формы var xhr = new XMLHttpRequest(); xhr.open("POST", "filter.php", true); xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8"); xhr.onreadystatechange = function() { if (xhr.readyState === XMLHttpRequest.DONE) { if (xhr.status === 200) { // Получаем данные из ответа сервера var data = JSON.parse(xhr.responseText);
    // Отображаем результаты в таблицах
    displayTable1(data.table1); // Отображение данных в таблице 1
    displayTable2(data.table2); // Отображение данных в таблице 2
    displayTable3(data.table3); // Отображение данных в таблице 3
    displayTable4(data.table4); // Отображение данных в таблице 4
  } else {
    console.error("Ошибка запроса: " + xhr.statusText);
  }
}
};
// Формируем данные для отправки на сервер var formData = new FormData(); formData.append("startDate", startDate); formData.append("endDate", endDate); xhr.send(formData); });
// Функция отображения данных в таблице 2 function displayTable2(data) { // Очищаем таблицу var table = document.getElementById("table2"); table.innerHTML = "";
// Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Оператор", "Результат звонка", "Количество обращений"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header);
// Отображаем данные в таблице for (var i = 0; i < data.length; i++) { var row = document.createElement("tr"); var cell1 = document.createElement("td"); var cell2 = document.createElement("td"); var cell3 = document.createElement("td"); cell1.textContent = data[i].operator; cell2.textContent = data[i].callResult; cell3.textContent = data[i].count; row.appendChild(cell1); row.appendChild(cell2); row.appendChild(cell3);
// Отображаем данные в таблице
table.appendChild(row);
} }
// Функция отображения данных в таблице 1 function displayTable1(data) { // Очищаем таблицу var table = document.getElementById("table1"); table.innerHTML = "";
// Создаем заголовок таблицы var header = document.createElement("tr"); var headers = ["Оператор", "AON_2", "Процент повторных значений"]; for (var i = 0; i < headers.length; i++) { var th = document.createElement("th"); th.textContent = headers[i]; th.onclick = function() { sortTable(table, this.cellIndex); }; header.appendChild(th); } table.appendChild(header);
// Отображаем данные в таблице for (var i = 0; i < data.length; i++) {
// JavaScript код для обработки формы фильтрации данных и отображения результатов в таблицах // Обработчик события отправки формы document.getElementById("filterForm").addEventListener("submit", function(event) { event.preventDefault();
// Получаем значения полей выбора дат var startDate = document.getElementById("startDate").value; var endDate = document.getElementById("endDate").value;
// Отправляем запрос на сервер с данными формы var xhr = new XMLHttpRequest(); xhr.open("POST", "filter.php", true); xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8"); xhr.onreadystatechange = function() { if (xhr.readyState === XMLHttpRequest.DONE) { if (xhr.status === 200) { // Получаем данные из ответа сервера var data = JSON.parse(xhr.responseText);
    // Отображаем результаты в таблицах
    displayTable1(data.table1); // Отображение данных в таблице 1
    displayTable2(data.table2); // Отображение данных в таблице 2
    displayTable3(data.table3); // Отображение данных в таблице 3
    displayTable4(data.table4); // Отображение данных в таблице 4
  } else {
    console.error("Ошибка запроса: " + xhr.statusText);
// JavaScript код для обработки формы фильтрации данных и отображения результатов в таблицах
// Обработчик события отправки формы document.getElementById("filterForm").addEventListener("submit", function(event) { event.preventDefault();
