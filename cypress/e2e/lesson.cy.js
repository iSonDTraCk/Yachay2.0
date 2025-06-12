describe('Página Home Principal', () => {
  it('Muestra el panel de lecciones', () => {
    cy.visit('http://127.0.0.1:8000'); // Asegúrate de que la URL sea correcta
    cy.contains('DNI');
  });
});

describe('Home de alumno', () => {
  it('Muestra el panel de lecciones', () => {
    cy.visit('/alumno/home'); // Usa la ruta relativa, aprovecha el baseUrl
    cy.contains('Nivel: Principiante'); // Cambia el texto por uno que realmente aparezca en tu vista
  });
});

describe('Home de profesor', () => {
  it('Muestra el panel de lecciones', () => {
    cy.visit('/profesor/home'); // Usa la ruta relativa, aprovecha el baseUrl
    cy.contains('Mis Clases'); // Cambia el texto por uno que realmente aparezca en tu vista
  });
  
});