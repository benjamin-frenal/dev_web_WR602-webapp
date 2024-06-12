
describe('Formulaire d\'Inscription', () => {
it('test 3 - inscription OK', () => {
    cy.visit('https://127.0.0.1:8000/register');

    // Entrer le nom d'utilisateur et le mot de passe
    cy.get('#registration_form_firstName').type('Apolline');
    cy.get('#registration_form_lastName').type('Boulot');
    cy.get('#registration_form_email').type('apolline.boulot@icloud.com');
    cy.get('#registration_form_plainPassword').type('123456');
    cy.get('#registration_form_agreeTerms').check();

    // Soumettre le formulaire
    cy.get('button[type="submit"]').click();

    // Vérifier que l'utilisateur est connecté
    cy.contains('Vous êtes connecté en tant que apolline.boulot@icloud.com').should('exist');
});

it('test 4 - inscription KO', () => {
    cy.visit('https://127.0.0.1:8000/register');

    // Entrer un nom d'utilisateur et un mot de passe incorrects
    cy.get('#registration_form_firstName').type('Apolline');
    cy.get('#registration_form_lastName').type('Boulot');
    cy.get('#registration_form_email').type('apolline.boulot@icloud.com');
    cy.get('#registration_form_plainPassword').type('0000');
    cy.get('#registration_form_agreeTerms').check();

    // Soumettre le formulaire
    cy.get('button[type="submit"]').click();

    // Vérifier que le message d'erreur est affiché
    cy.contains('Le mot de passe doit contenir au moins 6 caractères.').should('exist');
});
});