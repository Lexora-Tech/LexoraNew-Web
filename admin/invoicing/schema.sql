-- ==============================================
-- Lexora Tech — Quotation & Invoice Module
-- Database Migration Script
-- Run this in phpMyAdmin on: buwaggif_lexoraadmin
-- ==============================================

-- 1. CUSTOMERS TABLE
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `tax_id` varchar(100) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 2. QUOTATIONS TABLE
CREATE TABLE IF NOT EXISTS `quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_number` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` enum('draft','sent','accepted','rejected','converted','cancelled') DEFAULT 'draft',
  `issue_date` date NOT NULL,
  `valid_until` date DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT 0.00,
  `tax_amount` decimal(12,2) DEFAULT 0.00,
  `discount_amount` decimal(12,2) DEFAULT 0.00,
  `grand_total` decimal(12,2) DEFAULT 0.00,
  `currency` varchar(10) DEFAULT 'LKR',
  `payment_terms` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_number` (`quotation_number`),
  KEY `customer_id` (`customer_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 3. INVOICES TABLE
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(50) NOT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `status` enum('draft','sent','paid','overdue','cancelled','partial') DEFAULT 'draft',
  `issue_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT 0.00,
  `tax_amount` decimal(12,2) DEFAULT 0.00,
  `discount_amount` decimal(12,2) DEFAULT 0.00,
  `grand_total` decimal(12,2) DEFAULT 0.00,
  `amount_paid` decimal(12,2) DEFAULT 0.00,
  `currency` varchar(10) DEFAULT 'LKR',
  `payment_terms` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `is_recurring` tinyint(1) DEFAULT 0,
  `recurring_interval` enum('weekly','monthly','quarterly','yearly') DEFAULT NULL,
  `next_recurrence` date DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoice_number` (`invoice_number`),
  KEY `customer_id` (`customer_id`),
  KEY `quotation_id` (`quotation_id`),
  KEY `status` (`status`),
  KEY `due_date` (`due_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 4. INVOICE ITEMS TABLE (shared for quotations & invoices)
CREATE TABLE IF NOT EXISTS `invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_type` enum('quotation','invoice') NOT NULL,
  `parent_id` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `quantity` decimal(10,2) DEFAULT 1.00,
  `unit_price` decimal(12,2) DEFAULT 0.00,
  `tax_rate` decimal(5,2) DEFAULT 0.00,
  `discount` decimal(12,2) DEFAULT 0.00,
  `line_total` decimal(12,2) DEFAULT 0.00,
  `sort_order` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `parent_lookup` (`item_type`, `parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 5. PAYMENTS TABLE (future-ready for Stripe/PayPal)
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_method` enum('cash','bank_transfer','credit_card','paypal','stripe','cheque','other') DEFAULT 'bank_transfer',
  `transaction_id` varchar(255) DEFAULT NULL,
  `gateway` varchar(50) DEFAULT NULL,
  `gateway_response` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `payment_date` (`payment_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 6. COMPANY SETTINGS TABLE (for PDF/invoice branding)
CREATE TABLE IF NOT EXISTS `company_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) DEFAULT 'Lexora Tech',
  `company_email` varchar(255) DEFAULT 'info@lexoratech.com',
  `company_phone` varchar(50) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `company_website` varchar(255) DEFAULT 'https://lexoratech.com',
  `tax_number` varchar(100) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_name` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(100) DEFAULT NULL,
  `bank_branch` varchar(255) DEFAULT NULL,
  `bank_swift` varchar(50) DEFAULT NULL,
  `invoice_prefix` varchar(10) DEFAULT 'INV',
  `quotation_prefix` varchar(10) DEFAULT 'QUO',
  `default_currency` varchar(10) DEFAULT 'LKR',
  `default_tax_rate` decimal(5,2) DEFAULT 0.00,
  `default_payment_terms` text DEFAULT NULL,
  `invoice_footer_note` text DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT 587,
  `smtp_username` varchar(255) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `smtp_encryption` enum('tls','ssl','none') DEFAULT 'tls',
  `smtp_from_name` varchar(255) DEFAULT 'Lexora Tech',
  `smtp_from_email` varchar(255) DEFAULT 'info@lexoratech.com',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Insert default company settings row
INSERT INTO `company_settings` (`id`, `company_name`, `company_email`, `company_website`, `default_payment_terms`, `invoice_footer_note`)
VALUES (1, 'Lexora Tech', 'info@lexoratech.com', 'https://lexoratech.com', 'Payment due within 30 days of invoice date.', 'Thank you for your business! — Lexora Tech');

-- 7. SERVICE AGREEMENTS TABLE
CREATE TABLE IF NOT EXISTS `service_agreements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agreement_number` varchar(50) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `status` enum('draft','sent','signed','cancelled') DEFAULT 'draft',
  `effective_date` date DEFAULT NULL,
  `project_start_date` date DEFAULT NULL,
  `project_end_date` date DEFAULT NULL,
  `scope_of_services` text DEFAULT NULL,
  `payment_terms_text` text DEFAULT NULL,
  `late_payment_policy` text DEFAULT NULL,
  `confidentiality_clause` text DEFAULT NULL,
  `ip_clause` text DEFAULT NULL,
  `termination_clause` text DEFAULT NULL,
  `liability_clause` text DEFAULT NULL,
  `governing_law` text DEFAULT NULL,
  `dispute_resolution` text DEFAULT NULL,
  `force_majeure` text DEFAULT NULL,
  `amendments_clause` text DEFAULT NULL,
  `custom_notes` text DEFAULT NULL,
  `client_signature_name` varchar(255) DEFAULT NULL,
  `client_signature_date` date DEFAULT NULL,
  `company_signatory_name` varchar(255) DEFAULT NULL,
  `company_signatory_title` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agreement_number` (`agreement_number`),
  KEY `invoice_id` (`invoice_id`),
  KEY `customer_id` (`customer_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 8. AGREEMENT TEMPLATES TABLE
CREATE TABLE IF NOT EXISTS `agreement_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `template_name` varchar(255) NOT NULL,
  `clause_key` varchar(50) NOT NULL,
  `clause_content` text NOT NULL,
  `is_default` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `clause_key` (`clause_key`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Seed default agreement templates
INSERT INTO `agreement_templates` (`template_name`, `clause_key`, `clause_content`, `is_default`) VALUES
('Default Late Payment', 'late_payment_policy', 'If payment is not received within the agreed timeframe, a late fee of 2% per month shall be applied to the outstanding balance. The Service Provider reserves the right to suspend services until all overdue payments are settled in full.', 1),
('Default Confidentiality', 'confidentiality_clause', 'Both parties agree to keep confidential all proprietary information, trade secrets, business strategies, and technical data disclosed during the course of this agreement. This obligation shall survive the termination of this agreement for a period of two (2) years.', 1),
('Default IP Clause', 'ip_clause', 'All intellectual property, including but not limited to source code, designs, graphics, documentation, and other deliverables created under this agreement shall become the exclusive property of the Client upon receipt of full payment. Until full payment is received, the Service Provider retains all rights to the deliverables.', 1),
('Default Termination', 'termination_clause', 'Either party may terminate this agreement by providing thirty (30) days written notice to the other party. In the event of termination, the Client shall pay for all services rendered and expenses incurred up to the date of termination. The Service Provider shall deliver all completed work to the Client upon termination.', 1),
('Default Liability', 'liability_clause', 'The Service Provider\'s total liability under this agreement shall not exceed the total amount paid by the Client for the services. In no event shall either party be liable for any indirect, incidental, special, consequential, or punitive damages, regardless of the cause of action.', 1),
('Default Governing Law', 'governing_law', 'This agreement shall be governed by and construed in accordance with the laws of the Democratic Socialist Republic of Sri Lanka, without regard to its conflict of law provisions.', 1),
('Default Dispute Resolution', 'dispute_resolution', 'Any disputes arising out of or in connection with this agreement shall first be attempted to be resolved through good faith negotiation between the parties. If the dispute cannot be resolved within thirty (30) days, it shall be submitted to mediation, and if mediation fails, to the courts of competent jurisdiction in Sri Lanka.', 1),
('Default Force Majeure', 'force_majeure', 'Neither party shall be liable for any failure or delay in performing their obligations under this agreement where such failure or delay results from circumstances beyond the reasonable control of that party, including but not limited to acts of God, natural disasters, war, terrorism, pandemic, government actions, power failures, or internet disruptions.', 1),
('Default Amendments', 'amendments_clause', 'This agreement may only be amended or modified by a written document signed by both parties. No waiver of any provision of this agreement shall constitute a waiver of any other provision, nor shall any waiver constitute a continuing waiver.', 1);
