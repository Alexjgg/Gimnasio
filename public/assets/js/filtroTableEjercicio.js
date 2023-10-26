// Obtén la referencia al elemento de entrada de búsqueda
var input2 = document.getElementById('search-input-2');

// Obtén la referencia a la tabla
var table2 = document.getElementById('table2');

// Agrega un evento de escucha al evento 'input' del elemento de entrada de búsqueda
input2.addEventListener('input', function() {
  const searchTerm = input2.value.toLowerCase(); // Obtén el término de búsqueda y conviértelo a minúsculas

  // Recorre todas las filas de la tabla, empezando desde la segunda fila (índice 1)
  for (let i = 1; i < table2.rows.length; i++) {
    const row = table2.rows[i];
    let match = false;

    // Recorre todas las celdas de la fila
    for (let j = 0; j < row.cells.length; j++) {
      const cell = row.cells[j];
      const text = cell.textContent.toLowerCase(); // Obtén el contenido de texto de la celda y conviértelo a minúsculas

      if (text.includes(searchTerm)) {
        match = true;
        break;
      }
    }

    // Muestra u oculta la fila según si coincide con el término de búsqueda
    if (match) {
      row.style.display = 'table-row'; // Muestra la fila si coincide con el término de búsqueda
    } else {
      row.style.display = 'none'; // Oculta la fila si no coincide con el término de búsqueda
    }
  }
});
// Obtén la referencia al elemento de entrada de búsqueda
var input1 = document.getElementById('search-input-1');

// Obtén la referencia a la tabla
var table1 = document.getElementById('table1');

input1.addEventListener('input', function() {
  const searchTerm = input1.value.toLowerCase(); // Obtén el término de búsqueda y conviértelo a minúsculas

  // Recorre todas las filas de la tabla, empezando desde la segunda fila (índice 1)
  for (let i = 1; i < table1.rows.length; i++) {
    const row = table1.rows[i];
    let match = false;

    // Recorre todas las celdas de la fila
    for (let j = 0; j < row.cells.length; j++) {
      const cell = row.cells[j];
      const text = cell.textContent.toLowerCase(); // Obtén el contenido de texto de la celda y conviértelo a minúsculas

      if (text.includes(searchTerm)) {
        match = true;
        break;
      }
    }

    // Muestra u oculta la fila según si coincide con el término de búsqueda
    if (match) {
      row.style.display = 'table-row'; // Muestra la fila si coincide con el término de búsqueda
    } else {
      row.style.display = 'none'; // Oculta la fila si no coincide con el término de búsqueda
    }
  }
});