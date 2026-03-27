<?php
$pageTitle = $pageTitle ?? 'CampusConnect';
$extraHead = $extraHead ?? '';
$bodyClass = $bodyClass ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --cc-ink: #17324d;
            --cc-ink-soft: #59708a;
            --cc-surface: rgba(255, 255, 255, 0.84);
            --cc-line: rgba(23, 50, 77, 0.08);
            --cc-accent: #0f766e;
            --cc-accent-2: #ff8a00;
            --cc-shadow: 0 18px 45px rgba(20, 44, 73, 0.12);
        }

        html, body {
            font-family: "Instrument Sans", sans-serif;
            color: var(--cc-ink);
        }

        h1, h2, h3, h4, h5, .navbar-brand {
            font-family: "Space Grotesk", sans-serif;
            letter-spacing: -0.03em;
        }

        .page-heading {
            letter-spacing: -0.045em;
        }

        .shell {
            max-width: 1180px;
        }

        .surface-card {
            background: var(--cc-surface);
            border: 1px solid var(--cc-line);
            border-radius: 28px;
            box-shadow: var(--cc-shadow);
        }

        .form-control,
        .form-select,
        .btn {
            border-radius: 16px;
        }

        .form-control,
        .form-select {
            border: 1px solid rgba(23, 50, 77, 0.12);
            box-shadow: none;
            padding: 0.8rem 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(15, 118, 110, 0.45);
            box-shadow: 0 0 0 0.2rem rgba(15, 118, 110, 0.12);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0d5f59, #129b8c);
        }

        .btn-outline-primary {
            border-color: rgba(15, 118, 110, 0.35);
            color: #0f766e;
        }

        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-secondary:hover {
            transform: translateY(-1px);
        }

        .alert {
            border: 0;
            border-radius: 18px;
            box-shadow: var(--cc-shadow);
        }

        .soft-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.65);
            color: var(--cc-ink-soft);
            font-size: 0.85rem;
        }
    </style>
    <?= $extraHead ?>
</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">
