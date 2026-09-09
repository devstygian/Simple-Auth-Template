# Simple-Auth-Template — Full Documentation

> **Current focus:** Google OAuth 2.0 / OpenID Connect prototype
>
> **Primary integration target:** Nadine Resto-POS customer / landing-page authentication
>
> **Long-term goal:** A reusable, framework-free PHP + MySQL authentication template that can be integrated into other projects and eventually released as open source.

This document covers the current authentication system, repository structure, database design, local authentication flow, security practices, and the planned Google authentication integration.

---

## Table of Contents

1. [Overview](#overview)
2. [Project Goals](#project-goals)
3. [Repository Structure](#repository-structure)
4. [Current Authentication](#current-authentication)
5. [Database Schema](#database-schema)
6. [Configuration](#configuration)
7. [Local Auth Flow](#local-auth-flow)
8. [Core Functions](#core-functions)
9. [Pages & Routes](#pages--routes)
10. [Session Management](#session-management)
11. [Google OAuth / OpenID Connect](#google-oauth--openid-connect)
12. [Google OAuth Prototype](#google-oauth-prototype)
13. [Google OAuth Flow](#google-oauth-flow)
14. [Google Account Mapping](#google-account-mapping)
15. [Resto-POS Integration](#resto-pos-integration)
16. [Reusable OAuth Architecture](#reusable-oauth-architecture)
17. [Development Roadmap](#development-roadmap)
18. [Security Practices](#security-practices)
19. [Common Errors & Fixes](#common-errors--fixes)
20. [FAQ](#faq)
21. [References](#references)

---

## Overview

**Simple-Auth-Template** is a plain PHP + MySQL authentication starter project.

The current implementation provides a basic local authentication foundation:

- Registration
- Login
- Password hashing
- PHP sessions
- Protected pages
- Logout
- Basic project configuration

The project intentionally does not use a PHP framework. The goal is to keep the code readable and understandable for developers who know basic PHP, HTML, CSS, and MySQL.

The next major feature is **Google authentication** using Google's OAuth 2.0 / OpenID Connect capabilities.

The Google integration is being designed as a reusable authentication feature rather than a feature that only belongs to one application.

---

## Project Goals

### Short-term

- Keep the existing local authentication working.
- Build a working Google authentication prototype.
- Authenticate a Google account and create a local PHP session.
- Store the Google identity against a local user/customer account.

### Medium-term

- Integrate the authentication system into the Resto-POS landing page.
- Keep customer authentication separate from staff/admin authentication.
- Improve error handling and security.
- Make Google OAuth configuration reusable across projects.

### Long-term

- Separate authentication logic from application-specific code.
- Support additional OAuth providers where practical.
- Provide clear setup and integration documentation.
- Publish the reusable authentication template as an open-source project.

---

# Repository Structure

The current repository is intentionally small and is still evolving.

```text
Simple-Auth-Template/
│
├── Documentation.md          # Project and authentication documentation
├── readme.md                 # Short project overview
├── main.php                  # Main project/demo page
│
├── includes/
│   ├── auth.php              # Authentication logic
│   ├── config.php            # Application configuration
│   └── db.php                # Database connection
│
├── public/
│   ├── login.php             # Login page
│   ├── register.php          # Registration page
│   ├── logout.php            # Logout endpoint
│   └── assets/
│       └── css/
│           ├── auth.css
│           └── style.css
│
└── src/
    ├── footer.php            # Shared footer
    ├── header.php            # Shared header
    └── page2.php             # Additional demo page
```

> The structure may change as the OAuth module becomes more reusable. Do not treat the future architecture described later in this document as the current repository structure.

---

# Current Authentication

The current system uses traditional application-managed authentication.

```text
User
  ↓
Login / Register
  ↓
PHP
  ↓
MySQL
  ↓
PHP Session
  ↓
Protected Page
```

Passwords are handled by PHP password hashing functions rather than being stored as plain text.

Google authentication will be added alongside this system instead of immediately replacing it.

---

# Database Schema

The current authentication model uses a local `users` table.

Example schema:

```sql
CREATE DATABASE IF NOT EXISTS simple_auth;

USE simple_auth;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Column Breakdown

| Column | Type | Description |
|---|---|---|
| `id` | INT, PK, AUTO_INCREMENT | Local application user ID |
| `username` | VARCHAR(100) | User's display name |
| `email` | VARCHAR(150), UNIQUE | Local account email |
| `password` | VARCHAR(255) | Password hash for local authentication |
| `created_at` | TIMESTAMP | Account creation timestamp |

### Planned OAuth Extension

The Google integration should not use the Google account identifier as the application's primary user ID.

A future schema can separate provider information from the local user record:

```sql
CREATE TABLE user_oauth_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    provider VARCHAR(50) NOT NULL,
    provider_user_id VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_provider_user (
        provider,
        provider_user_id
    ),

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);
```

This design allows one local user to potentially have multiple authentication providers later.

Example:

```text
users
  │
  ├── local password
  │
  └── user_oauth_accounts
          ├── google
          ├── github       (future)
          └── other       (future)
```

For the Resto-POS integration, the same concept can be applied to a dedicated `customers` table so customer accounts remain separate from staff/admin accounts.

---

# Configuration

The current database/application configuration is stored in:

```text
includes/config.php
```

Typical configuration values include:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'simple_auth');
define('BASE_URL', 'http://localhost/Simple-Auth-Template/public');
```

### Planned Google configuration

Google OAuth credentials should not be committed to a public repository.

A future configuration can use environment variables or an ignored local configuration file:

```text
GOOGLE_CLIENT_ID
GOOGLE_CLIENT_SECRET
GOOGLE_REDIRECT_URI
```

Recommended repository pattern:

```text
config/google.example.php   # Safe example with empty values
config/google.php           # Local secrets; ignored by Git
```

Never commit a real Google client secret.

---

# Local Auth Flow

## Registration Flow

```text
User fills registration form
        ↓
Server receives POST data
        ↓
Validate input
        ↓
Check whether email already exists
        ↓
password_hash()
        ↓
Insert user into MySQL
        ↓
Redirect to login
```

## Login Flow

```text
User enters email + password
        ↓
Server receives POST data
        ↓
Find local user
        ↓
password_verify()
        ↓
Create PHP session
        ↓
Redirect to protected page
```

## Auth Guard Flow

```text
User requests protected page
        ↓
auth_guard()
        ↓
Check PHP session
        ↓
Authenticated?
   ┌────┴────┐
  YES        NO
   ↓          ↓
Page loads   Redirect to login
```

## Logout Flow

```text
User clicks logout
        ↓
logout.php
        ↓
session_unset()
        ↓
session_destroy()
        ↓
Redirect to login
```

---

# Core Functions

The authentication layer is centered around functions such as:

### `register_user($username, $email, $password)`

Creates a local user account and returns a success value or an error.

### `login_user($email, $password)`

Validates the user's password and creates the authenticated PHP session.

### `auth_guard()`

Protects pages that require authentication.

### `is_logged_in()`

Returns whether the current session contains an authenticated local user.

### `logout_user()`

Clears the current authentication session.

> Function names and implementation may evolve as the reusable authentication module is refactored.

---

# Pages & Routes

Current public authentication pages include:

| File | Purpose |
|---|---|
| `public/login.php` | Local login form |
| `public/register.php` | Local registration form |
| `public/logout.php` | Logout endpoint |

The exact URL depends on the configured local web root.

Example:

```text
http://localhost/Simple-Auth-Template/public/login.php
```

Future Google authentication endpoints are expected to live in a dedicated authentication area, for example:

```text
/auth/google/login.php
/auth/google/callback.php
```

The exact path is not finalized during the prototype stage.

---

# Session Management

The local authentication system uses PHP native sessions.

Example local session values:

```php
$_SESSION['user_id'];
$_SESSION['username'];
```

For the future Resto-POS customer authentication flow, customer sessions should remain separate from staff/admin sessions.

Example target design:

```php
// Customer
$_SESSION['customer_id'];
$_SESSION['customer_authenticated'];

// Staff/Admin
$_SESSION['user_id'];
$_SESSION['role'];
```

This separation is important because a customer authenticated through Google must not automatically receive staff or admin privileges.

---

# Google OAuth / OpenID Connect

## Why Google OAuth?

The goal is to allow users to authenticate through their Google account instead of creating another password for the application.

The intended flow is:

```text
Customer
   ↓
Landing Page
   ↓
Continue with Google
   ↓
Google authentication
   ↓
Google identity
   ↓
Local customer account
   ↓
PHP session
   ↓
Ordering system
```

## OAuth 2.0 vs OpenID Connect

OAuth 2.0 is primarily an authorization protocol. OpenID Connect (OIDC) adds an identity layer on top of OAuth 2.0.

For this project, the requirement is authentication — identifying who the Google user is — so the implementation should use Google's identity capabilities rather than treating an access token as a user ID.

Google's current Sign in with Google documentation identifies the `sub` claim as the unique Google Account identifier and requires server-side verification of the returned ID token. See the official documentation:

https://developers.google.com/identity/gsi/web/reference/html-reference

---

# Google OAuth Prototype

## Prototype Objective

The first milestone is intentionally small.

> **Prove that one Google account can authenticate successfully and create a local PHP session.**

Do not build the complete reusable framework before this works.

### Prototype checklist

```text
[ ] Create/configure Google Cloud project
[ ] Configure Google OAuth credentials
[ ] Configure authorized redirect URI
[ ] Add Google login button/link
[ ] Start authentication flow
[ ] Receive Google's response
[ ] Validate the response
[ ] Obtain Google identity
[ ] Create local PHP session
[ ] Display authenticated user
[ ] Logout
```

The prototype does not need to solve every future use case.

---

# Google OAuth Flow

The target server-side authorization flow is:

```text
1. User clicks "Continue with Google"
        ↓
2. Application generates a random state value
        ↓
3. State is stored in the PHP session
        ↓
4. Browser is redirected to Google
        ↓
5. User selects/authenticates a Google account
        ↓
6. Google returns an authorization response
        ↓
7. Application validates state
        ↓
8. Application exchanges the authorization code / processes the identity response
        ↓
9. Application validates the Google identity token
        ↓
10. Application finds or creates the local user/customer
        ↓
11. Application creates its own PHP session
        ↓
12. User is redirected to the application
```

Google's current identity documentation also supports the Sign in with Google HTML/JavaScript APIs, which can return an ID token directly to a server login endpoint. The exact Google flow should be selected based on the prototype implementation and desired UX.

Official reference:

https://developers.google.com/identity/gsi/web/reference/js-reference

---

# OAuth State

The OAuth `state` value is a security mechanism used to associate the response with the authentication request initiated by the application.

Example:

```php
$state = bin2hex(random_bytes(32));
$_SESSION['oauth_state'] = $state;
```

When the response returns, the application should verify the value before continuing.

Conceptually:

```php
if (!isset($_GET['state'])) {
    exit('Missing OAuth state.');
}

if (!isset($_SESSION['oauth_state'])) {
    exit('Missing session state.');
}

if (!hash_equals($_SESSION['oauth_state'], $_GET['state'])) {
    exit('Invalid OAuth state.');
}

unset($_SESSION['oauth_state']);
```

The exact callback parameters depend on the selected Google authentication flow.

---

# Google Identity / ID Token

A Google ID token is a signed JWT containing identity claims.

Important claims include:

```text
iss       Issuer
sub       Stable Google account identifier
aud       Audience / client ID
email     User email
name      User name, when provided
picture   Profile image, when provided
exp       Token expiration time
```

The `sub` value should be treated as the provider-specific Google user ID.

Example:

```text
Google Account
      ↓
Google `sub`
      ↓
user_oauth_accounts.provider_user_id
      ↓
local user_id / customer_id
      ↓
PHP session
```

Do not use the Google access token as the local user ID.

Google's documentation states that the ID token must be verified before trusting its claims and that `exp` is for token validation, not for determining whether the application's local session has ended.

---

# Access Token vs ID Token

These tokens have different purposes.

### ID Token

Used to communicate authenticated identity information to the application.

```text
Who is the user?
```

### Access Token

Used to authorize calls to Google APIs on behalf of the user.

```text
What Google API data/actions did the user authorize?
```

For the initial login prototype, the application should request only the identity information it actually needs.

Do not add Google API permissions such as Drive, Calendar, YouTube, etc. unless a real feature requires them.

---

# Google Scopes

For a basic identity/login implementation, the target identity scopes are:

```text
openid
email
profile
```

Only request additional scopes when the application genuinely needs access to another Google API.

This keeps the authentication flow simpler and reduces unnecessary permissions.

---

# Google OAuth Configuration

A web application OAuth client requires configuration such as:

```text
Client ID
Client Secret
Authorized redirect URI
```

Example development redirect URI:

```text
http://localhost/Simple-Auth-Template/auth/google/callback.php
```

Example Resto-POS development URI:

```text
http://localhost/Resto-POS/auth/google/callback.php
```

Production should use the actual HTTPS domain and a registered redirect URI.

Redirect URIs must match the Google configuration exactly.

For production deployments, Google requires secure redirect URIs and JavaScript origins. See:

https://developers.google.com/identity/protocols/oauth2/production-readiness/policy-compliance

---

# Google Account Mapping

The application should maintain its own user/customer record.

The preferred mapping is:

```text
Google
  │
  │ provider = google
  │ provider_user_id = sub
  ▼
OAuth account table
  │
  │ local user_id / customer_id
  ▼
Application account
  │
  ▼
PHP session
```

### Existing Google account

```text
Google identity received
        ↓
Find provider + provider_user_id
        ↓
Found
        ↓
Load local account
        ↓
Create session
```

### New Google account

```text
Google identity received
        ↓
Provider account not found
        ↓
Check local email/account rules
        ↓
Create or link local account
        ↓
Create OAuth relationship
        ↓
Create session
```

Account-linking rules must be designed carefully before production. Automatically merging accounts solely because an email address matches should only be done when the application's identity rules support it safely.

---

# Resto-POS Integration

The first real integration target is the Resto-POS customer landing page.

The authentication systems should remain logically separate:

### Customer

```text
Landing Page
    ↓
Google Login / Local Customer Login
    ↓
customer_id
    ↓
Menu
    ↓
Cart
    ↓
Checkout
    ↓
Order
```

### Staff/Admin

```text
Existing Staff/Admin Login
    ↓
Role
    ↓
POS / Admin Dashboard
```

### Important rule

```text
Customer authentication ≠ Staff/Admin authorization
```

A Google-authenticated customer must not receive `admin` or `staff` permissions simply because the customer authenticated successfully.

This matches the larger Resto-POS architecture direction where customer, staff, and administrator functions are protected independently.

---

# Reusable OAuth Architecture

The long-term goal is to make the Google implementation reusable instead of writing a separate Google login implementation for every project.

The target architecture is approximately:

```text
Simple-Auth-Template
│
├── Local Authentication
│
├── OAuth Layer
│   ├── Google
│   ├── GitHub (future)
│   └── Other providers (future)
│
├── User / Customer Mapping
│
└── Session Management
```

Application-specific code should communicate with the reusable authentication layer rather than directly implementing Google's protocol everywhere.

A future API could expose functions similar to:

```php
google_authorization_url();
google_handle_callback();
google_get_identity();
find_or_create_oauth_user();
```

Or, if the project remains procedural:

```php
google_get_authorization_url();
google_handle_callback();
google_get_user();
google_find_or_create_user();
```

The exact API is intentionally not finalized during the prototype stage.

---

# Configuration-Based Reuse

Different projects should eventually provide only their own configuration.

Example:

```php
$googleConfig = [
    'client_id' => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
];
```

The OAuth logic should not need to know whether it is being used by:

- Resto-POS
- A portfolio
- A blog
- An e-commerce project
- A school project
- Another PHP application

Only the configuration and application-specific user mapping should change.

---

# Development Roadmap

The recommended order is:

```text
Prototype
    ↓
MVP
    ↓
Resto-POS Integration
    ↓
Reusable Authentication Module
    ↓
Open Source Release
```

## Phase 1 — Prototype

**Priority: CURRENT**

Goal: prove that Google authentication works.

```text
[ ] Google Cloud configuration
[ ] OAuth credentials
[ ] Login UI
[ ] Google authentication flow
[ ] Callback / response handling
[ ] State / security validation
[ ] Identity verification
[ ] PHP session
[ ] Logout
```

### Prototype definition of done

One Google account can:

```text
Click Login
   ↓
Authenticate with Google
   ↓
Return to the application
   ↓
Be recognized by PHP
   ↓
Receive a local authenticated session
   ↓
Access a protected page
   ↓
Logout
```

---

## Phase 2 — MVP

Goal: connect Google authentication to the local database.

```text
[ ] OAuth account table
[ ] Local user/customer mapping
[ ] Existing account detection
[ ] New account creation
[ ] Safe account-linking rules
[ ] Customer session
[ ] Error handling
[ ] Secure configuration
[ ] Session ID regeneration after authentication
```

Result:

```text
Google Authentication
        ↓
Local MySQL Account
        ↓
Application Session
```

---

## Phase 3 — Resto-POS Integration

Goal: connect customer authentication to the restaurant landing page and ordering flow.

```text
Landing Page
    ↓
Customer Login
    ↓
Google / Local Auth
    ↓
Customer Session
    ↓
Menu
    ↓
Cart
    ↓
Checkout
    ↓
Order
```

Staff/admin authentication remains separate.

---

## Phase 4 — Reusable Authentication Module

Goal: make the authentication system portable to other PHP projects.

```text
[ ] Separate OAuth logic
[ ] Configuration system
[ ] Provider abstraction
[ ] Reusable user mapping
[ ] Better error handling
[ ] Security hardening
[ ] Example integration
[ ] Installation guide
```

---

## Phase 5 — Open Source Release

Goal: make the project usable by other developers.

```text
[ ] Clean README
[ ] Full Documentation.md
[ ] Installation guide
[ ] Google Cloud setup guide
[ ] Database schema
[ ] Example configuration
[ ] Security guide
[ ] Contributing guide
[ ] License
[ ] Example project
[ ] Remove all secrets/test credentials
```

---

# Security Practices

The current project is an educational/reusable starter and should be hardened before production use.

## Current practices

| Practice | Status / Direction |
|---|---|
| Password hashing | Use `password_hash()` |
| Password verification | Use `password_verify()` |
| PHP sessions | Used for application authentication |
| Protected routes | Use authentication guards |
| OAuth state | Required for OAuth authorization flows |
| Google ID token validation | Required before trusting identity claims |
| HTTPS | Required for production |
| Prepared statements | Recommended for all database queries |
| CSRF protection | Required before production |
| Rate limiting | Recommended for login endpoints |
| Secret management | Never commit client secrets |

## OAuth security checklist

```text
[ ] Validate state
[ ] Use cryptographically random state values
[ ] Validate ID token signature / claims using an appropriate library or Google's recommended verification method
[ ] Validate issuer
[ ] Validate audience/client ID
[ ] Validate expiration
[ ] Protect client secret
[ ] Use exact redirect URIs
[ ] Use HTTPS in production
[ ] Do not store unnecessary Google tokens
[ ] Request only required scopes
```

## Session security checklist

```text
[ ] Regenerate session ID after successful login
[ ] Use secure cookies in production
[ ] Use HttpOnly cookies
[ ] Use SameSite cookie protection
[ ] Destroy sessions on logout
[ ] Keep customer and staff/admin sessions logically separate
```

## Database security checklist

```text
[ ] Use prepared statements
[ ] Validate input
[ ] Use unique provider identifiers
[ ] Avoid storing unnecessary OAuth tokens
[ ] Never store Google passwords
```

---

# Common Errors & Fixes

| Error | Likely Cause | Fix |
|---|---|---|
| `Connection failed` | Wrong MySQL credentials | Check `includes/config.php` |
| Blank page after login | Session not started | Start the PHP session before accessing `$_SESSION` |
| Redirect loop | Auth guard/session mismatch | Check session initialization and guard logic |
| `Call to undefined function` | Missing include | Verify `require_once` paths |
| Password always wrong | Incorrect hashing/verification | Hash during registration and verify during login |
| `redirect_uri_mismatch` | Callback URI does not exactly match Google configuration | Check Google OAuth client settings and application URI |
| Invalid OAuth state | State was missing, changed, or session state was lost | Generate/store/validate state correctly |
| Invalid ID token | Token failed validation | Validate signature and required claims before creating a session |
| Google login works but local account is missing | OAuth identity was not mapped to local DB | Implement provider/account mapping |

---

# UI & Styling

The project currently uses plain HTML and CSS.

The authentication UI can be styled independently from the authentication logic.

This is important for reuse: a future project should be able to use the same authentication backend while providing its own UI.

---

# Extending the Template

## Adding a Protected Page

A protected page should include the authentication layer and call the appropriate guard before displaying private content.

Conceptually:

```php
<?php
require_once '../includes/auth.php';
auth_guard();
?>

<h1>Protected Page</h1>
```

The exact include path depends on the page location.

---

## Adding OAuth Providers Later

The planned provider model is:

```text
Authentication
├── Local
├── Google
├── GitHub
└── Future Providers
```

Each provider should be responsible for its provider-specific authentication flow while the application continues using its own local user/customer ID.

---

# FAQ

### Can I use this with Laravel?

Yes, but the current project is intentionally framework-free. A Laravel implementation would likely use Laravel's authentication and OAuth ecosystem instead of copying the procedural implementation directly.

### Is Google OAuth already production-ready?

No. The current Google work is planned as a **prototype first**. Security validation, account linking, secret management, HTTPS, error handling, and production configuration must be completed before production deployment.

### Do I need an access token just to log users in with Google?

Not necessarily. Basic Google authentication focuses on obtaining and verifying the user's identity. An access token is primarily needed when the application wants to call an authorized Google API on the user's behalf.

### Should the Google ID be the same as my application's user ID?

No. Keep a local application user/customer ID and map the Google provider ID (`sub`) to that local account.

### Can this eventually support GitHub or other providers?

Yes. That is one of the long-term goals. The provider-specific implementation should be separated from the application's local account/session logic.

### Why keep customer authentication separate from staff/admin authentication in Resto-POS?

Because authentication answers **who the user is**, while authorization determines **what the user is allowed to do**. A customer signing in with Google should not automatically gain staff/admin privileges.

### Why not build the reusable framework first?

Because the project is still validating the Google authentication flow. The recommended approach is to make the smallest working prototype first, then refactor the working implementation into reusable components.

---

# References

## Google

- Google OAuth 2.0 documentation:
  https://developers.google.com/identity/protocols/oauth2

- Google Sign in with Google HTML API reference:
  https://developers.google.com/identity/gsi/web/reference/html-reference

- Google Sign in with Google JavaScript API reference:
  https://developers.google.com/identity/gsi/web/reference/js-reference

- Google OAuth production-readiness and policy guidance:
  https://developers.google.com/identity/protocols/oauth2/production-readiness/policy-compliance

## Project

- Repository:
  https://github.com/devstygian/Simple-Auth-Template

## Video Reference

- YouTube reference used during planning:
  https://youtu.be/z4tU69VlHFQ

---

# Current Priority

The immediate goal is **Phase 1 — Prototype**.

Do not implement the entire reusable authentication architecture yet.

The next development target is:

```text
Simple-Auth-Template
        ↓
Google Login
        ↓
Google Identity
        ↓
PHP Session
        ↓
Protected Page
```

Once that flow works reliably, the project can move to MySQL account mapping, Resto-POS integration, reusable abstractions, and finally an open-source release.

---

*Documentation maintained as the Simple-Auth-Template project evolves.*
