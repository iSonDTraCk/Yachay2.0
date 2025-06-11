describe('Página de alumno', () => {
  it('Muestra el panel de lecciones', () => {
    cy.visit('http://127.0.0.1:8000');
    cy.contains('Nivel: Principiante');
  });
});