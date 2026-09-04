<?php
require_once __DIR__ . '/helpers.php';
require_auth();
$user = admin_user();
$current = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Painel Carlos Aníbal</title>
<link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
<div class="admin-shell">
<aside class="sidebar" id="sidebar">
    <a class="admin-brand" href="dashboard.php"><span class="brand-mark">↗</span><span>CARLOS <b>ANÍBAL</b><small>Painel administrativo</small></span></a>
    <nav>
        <a class="<?= $current==='dashboard.php'?'active':'' ?>" href="dashboard.php">Dashboard</a>
        <a class="<?= in_array($current,['alunos.php','aluno.php'],true)?'active':'' ?>" href="alunos.php">Alunos</a>
        <a href="alunos.php#documentos">Documentos</a>
        <a class="<?= $current==='configuracoes.php'?'active':'' ?>" href="configuracoes.php">Configurações</a>
        <a href="../index.php" target="_blank">Ver site público</a>
    </nav>
    <div class="sidebar-user"><span><?= e($user['name'] ?? 'Administrador') ?></span><a href="logout.php">Sair</a></div>
</aside>
<main class="admin-main">
<header class="admin-top"><button class="menu-toggle" id="menuToggle" aria-label="Abrir menu">☰</button><div><strong>Painel de Gestão</strong><span>Alunos, evolução, frequência e documentos</span></div></header>
