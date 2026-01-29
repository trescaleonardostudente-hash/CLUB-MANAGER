# AI Coding Guidelines for CLUB-MANAGER

## Project Overview
CLUB-MANAGER is a PHP/MySQL web application for managing amateur soccer clubs, centralizing teams, players, coaches, fields, and training schedules to reduce administrative overhead.

## Architecture
- **Frontend**: HTML/CSS/JavaScript served via Apache
- **Backend**: PHP with session-based authentication
- **Database**: MySQL (MariaDB) with schema in `clubmanager.sql`
- **Deployment**: LAMP stack, phpMyAdmin for database administration

Key tables include: `squadre` (teams), `giocatori` (players), `allenatori` (coaches), `campi` (fields), `allenamenti` (trainings), `categorie` (categories with values like 'Primi Calci', 'Pulcini', 'Esordienti')

## Setup and Development Workflow
1. Run `./install.sh` to install Apache, PHP, MariaDB, and phpMyAdmin
2. Run `./start.sh` to start Apache and MariaDB services
3. Access the application at `http://localhost/clubmanager`, phpMyAdmin at `http://localhost/phpmyadmin`

Use phpMyAdmin for database queries and schema inspection during development.

## Coding Patterns
- Use PHP sessions for user authentication and role management (admin, coach, viewer)
- Database interactions via mysqli (common in PHP projects)
- File uploads for documents (certificates, cards) in PDF/JPG/PNG formats, stored locally
- AJAX for dynamic updates, e.g., training schedule modifications
- Italian language for user-facing strings and some code elements (e.g., table names like `allenamenti`)

## Key Files and Directories
- `clubmanager.sql`: Complete database schema with initial category data
- `public/index.php`: Main application entry point (session initialization)
- `README.md`: Detailed functional requirements in Italian
- Diagrams: `DiagrammaER.png` (ER diagram), `D_Casi_D_uso_DEF.png` (use cases)

## Project-Specific Conventions
- User roles: Admin (full access), Coach (edit own team/schedule), Viewer (read-only)
- Categories ordered by age: Primi Calci → Pulcini → Esordienti → Giovanissimi → Allievi → Juniores
- Training scheduling with conflict detection and recurrence options
- Document management with expiration alerts for medical certificates and FIGC cards

## Development Tips
- Test role-based access thoroughly (admin vs. coach vs. viewer permissions)
- Implement drag-and-drop for training rescheduling if adding JS libraries
- Use phpMyAdmin's SQL editor for complex queries during feature development
- Follow Italian naming conventions for new database fields/tables if extending schema</content>
<parameter name="filePath">/workspaces/CLUB-MANAGER/.github/copilot-instructions.md