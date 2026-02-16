# Carbon Copy (CC/BCC) Extension

Some contacts require that specific individuals—such as an assistant, a colleague, or a parent—be included in all correspondence. The **Carbon Copy** extension automates this process by applying CC and BCC rules globally based on the contact’s record.

---

## How it Works: New Location Types

Upon installation, the extension adds two new **Location Types** to your CiviCRM instance:

* **CC To**: Any email address assigned this type will be automatically added to the `CC` field.
* **BCC To**: Any email address assigned this type will be automatically added to the `BCC` field.

You can add an unlimited number of these location-specific email addresses to any contact record.

---

## Automated Routing

The extension monitors outgoing mail across the entire system. Whenever an email is sent to a primary recipient, CiviCRM checks for these specific location types and appends them to the mail headers. This applies to:

1.  **Transactional Mail**: Individual emails, receipts, and workflow notifications.
2.  **Mass Mailing**: Bulk mailings sent via CiviMail or Mosaico.

---

## Token Replacement & Privacy

> **Token Context:** All tokens within the email body (e.g., `{contact.first_name}`) resolve to the **Primary Recipient**.

Because CC/BCC recipients are viewing a copy of the primary recipient's mail, they will see the primary contact's data. Please ensure that the content of your automated emails is appropriate for these additional parties to view.
