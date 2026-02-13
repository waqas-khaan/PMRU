<h2>Dashboard</h2>
<p>Welcome, {{ auth()->user()->name }}</p>
<p>Your Roles: {{ implode(', ', auth()->user()->roles->pluck('name')->toArray()) }}</p>

<form method="POST" action="{{ route('auth.logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>