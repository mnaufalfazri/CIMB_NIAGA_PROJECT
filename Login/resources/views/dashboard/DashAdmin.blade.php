<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banking Dashboard</title>

  <link rel="stylesheet" href="{{asset('dashboard/css/dash1.css')}}">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      CIMB<span>bank</span>
    </div>
    <div class="logo">
      <h5>Admin</h5>
    </div>

    <nav>
      <a href="#" class="active">Dashboard</a>
      <a href="#">Transactions</a>
      <a href="#">Cards</a>
      <a href="#">Transfer</a>
      <a href="#">Analytics</a>
      <a href="#">Settings</a>
      <a href="/logout">Log Out</a>
    </nav>
  </aside>

  <!-- Main -->
  <main class="main">

    <!-- Topbar -->
    <header class="topbar">
      <div>
        <h1>Welcome Back {{auth()-> user()-> name}}</h1>
        <p>Manage your banking activity</p>
      </div>

      <button id="themeBtn">Dark Mode</button>
    </header>

    <!-- Balance Card -->
    <section class="balance-card">
      <div>
        <p>Total Balance</p>
        <h2>$24,580.00</h2>
      </div>

      <div class="card-chip"></div>
    </section>

    <!-- Stats -->
    <section class="stats">

      <div class="stat-box">
        <h3>Income</h3>
        <p>$8,200</p>
      </div>

      <div class="stat-box">
        <h3>Expenses</h3>
        <p>$3,480</p>
      </div>

      <div class="stat-box">
        <h3>Savings</h3>
        <p>$12,900</p>
      </div>

    </section>

    <!-- Transactions -->
    <section class="transactions">

      <div class="section-title">
        <h2>Recent Transactions</h2>
      </div>

      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>Netflix</td>
            <td>10 May 2026</td>
            <td class="minus">- $15</td>
            <td><span class="success">Completed</span></td>
          </tr>

          <tr>
            <td>Salary</td>
            <td>09 May 2026</td>
            <td class="plus">+ $2,400</td>
            <td><span class="success">Completed</span></td>
          </tr>

          <tr>
            <td>Electric Bill</td>
            <td>08 May 2026</td>
            <td class="minus">- $120</td>
            <td><span class="pending">Pending</span></td>
          </tr>
        </tbody>
      </table>

    </section>

  </main>

  <!-- JS -->
  <script src="{{asset('dashboard/js/dash1.js')}}"></script>
</body>
</html>