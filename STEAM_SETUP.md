# Steam Login Setup Instructions

This guide will help you set up Steam authentication for both customer and employee portals.

## Prerequisites

1. Steam API Key from [Steam Community Developer](https://steamcommunity.com/dev/apikey)
2. A working Laravel application with the requirements installed

## Installation

### 1. Database Setup

The following tables have been created:

- **ranks**: Stores employee rank definitions
  - id (auto-increment)
  - name (rank name)
  
- **employees**: Stores employee information
  - id (auto-increment)
  - steam_id (unique Steam ID)
  - first_name
  - last_name
  - phone_number
  - rank_id (foreign key to ranks)
  
- **users**: Extended with steam_id field for customer Steam authentication

### 2. Environment Configuration

Add your Steam API key to your `.env` file:

```bash
STEAM_API_KEY=your_steam_api_key_here
```

### 3. Default Data

The following default data has been seeded:

**Ranks:**
- 1: Trainee
- 2: Employee  
- 3: Ausbilder
- 4: Chief Executive Officer

**Initial Employee:**
- Steam ID: 76561198147896830
- Name: Sam White
- Phone: 0659177288
- Rank: Chief Executive Officer (4)

## Usage

### Customer Portal
1. Navigate to `/login`
2. Click "Continue with Steam" button
3. Authenticate with Steam
4. Automatically redirected to customer dashboard

### Employee Portal
1. Navigate to `/employee/login` or use "Mitarbeiter" link on homepage
2. Click "Mit Steam anmelden"
3. Authenticate with Steam
4. Only employees with registered Steam IDs can access
5. Redirected to employee dashboard with rank information

## Routes

- `GET /auth/steam` - Initiate Steam authentication
- `GET /auth/steam/callback` - Handle Steam callback
- `GET /employee/login` - Employee login page
- `GET /mitarbeiter/` - Employee dashboard (protected)
- `POST /employee/logout` - Employee logout

## Middleware

- `employee.auth` - Protects employee routes, checks session for authenticated employee

## Adding New Employees

To add new employees, insert records into the `employees` table:

```php
Employee::create([
    'steam_id' => 'STEAM_ID_HERE',
    'first_name' => 'First Name',
    'last_name' => 'Last Name', 
    'phone_number' => 'Phone Number',
    'rank_id' => 1, // 1-4 based on ranks table
]);
```

## Troubleshooting

1. **Steam authentication fails**: Check that your Steam API key is correctly set in `.env`
2. **Employee can't access**: Verify their Steam ID is correctly stored in the employees table
3. **Redirect issues**: Ensure your APP_URL is correctly set in `.env`

## Security Notes

- Steam IDs are unique identifiers and should not be changed once set
- Employee access is controlled via database records, not Steam group membership
- Session-based authentication is used for employees (not Laravel's default auth)
- Customer Steam authentication integrates with Laravel's built-in auth system
