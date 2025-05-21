Here’s an enhanced list of **Low**, **Medium**, and **High Threat vulnerabilities** including **example sites** (fictional or illustrative only — **not real-world** sites unless explicitly mentioned from known security incidents):

---

### ✅ Vulnerability Threat Levels with Example Sites

| **Threat Level** | **Vulnerability**           | **Example Site**                                | **Description**                                                |
| ---------------- | --------------------------- | ----------------------------------------------- | -------------------------------------------------------------- |
| **High**         | SQL Injection               | `http://vulnsite.com/login.php?id=1' OR '1'='1` | Malicious input in SQL statements allows DB access.            |
| **High**         | Remote Code Execution (RCE) | `http://hackedsite.org/uploads/shell.php`       | Arbitrary code executed via file upload or eval().             |
| **High**         | Authentication Bypass       | `http://breachedportal.com/admin`               | Flawed auth logic lets attackers skip login.                   |
| **High**         | Insecure Deserialization    | `http://oldcms.org/api?data=...`                | Crafted serialized input leads to RCE or privilege escalation. |
| **High**         | Unrestricted File Upload    | `http://target.com/upload`                      | Accepts any file type without validation (e.g., PHP).          |

\| **Medium**       | Cross-Site Scripting (XSS)         | `http://example.com/search?q=<script>alert(1)</script>` | Injected JavaScript runs in user browser. |
\| **Medium**       | Cross-Site Request Forgery (CSRF)  | `http://fakebank.com/transfer?amt=1000` | Exploits logged-in users via hidden requests. |
\| **Medium**       | Broken Access Control              | `http://unsecuredapp.net/user/42/edit` | Users can view/edit others’ data. |
\| **Medium**       | Weak Password Policies             | `http://shopnow.com/register` | Accepts short or common passwords like "123456". |
\| **Medium**       | Sensitive Data in URL              | `http://portal.com/reset?token=abc123` | Leaks password reset tokens in URL. |

\| **Low**          | Directory Listing Enabled          | `http://oldsite.org/images/` | Lists all files in a folder. |
\| **Low**          | Server Banner Disclosure           | `http://myserver.com` returns `Apache/2.4.41 (Ubuntu)` | Shows server version in headers. |
\| **Low**          | Missing Security Headers           | `http://basicpage.com` lacks `X-Frame-Options`, `Content-Security-Policy` | No headers to prevent framing/XSS. |
\| **Low**          | Autocomplete on Password Fields    | `http://signin.org/login` has `<input type="password" autocomplete="on">` | Stores passwords in browser. |
\| **Low**          | Email or Phone Disclosure          | `http://profilepage.com` HTML source contains `<meta name="email" content="user@example.com">` | Info disclosure for phishing. |

---

### 🗂 JSON Version with Example Sites

```json
[
  {
    "name": "SQL Injection",
    "severity": "High",
    "example_site": "http://vulnsite.com/login.php?id=1' OR '1'='1",
    "description": "Allows attackers to manipulate SQL queries and access or modify sensitive data."
  },
  {
    "name": "Cross-Site Scripting (XSS)",
    "severity": "Medium",
    "example_site": "http://example.com/search?q=<script>alert(1)</script>",
    "description": "Injects malicious JavaScript into web pages viewed by other users."
  },
  {
    "name": "Directory Listing Enabled",
    "severity": "Low",
    "example_site": "http://oldsite.org/images/",
    "description": "Exposes file and folder structure to the public."
  }
]
```

---

Would you like this full list saved as a JSON or integrated directly into your scanning result logic for the dashboard?
