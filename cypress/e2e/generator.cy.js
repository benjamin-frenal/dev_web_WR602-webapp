describe('Générateur de PDF', () => {
    it('test 5 - Générateur OK', () => {
        cy.visit('https://127.0.0.1:8000/generate/pdf');
        cy.url().should('include', 'https://127.0.0.1:8000/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('ben.frenal@icloud.com');
        cy.get('#password').type('123456');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        cy.url().should('include', 'https://127.0.0.1:8000/generate/pdf');
        cy.visit('https://127.0.0.1:8000/generate/pdf');

        cy.get('#generate_pdf_form_url').type('https://www.apple.com/fr/');
        cy.get('#generate_pdf_form_pdfName').type('Apple FR');
        cy.get('#generate_pdf_form_submit').click();
    });
});