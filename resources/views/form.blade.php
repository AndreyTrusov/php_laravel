<h1>Vyplnite formular</h1>

<form action="{{ url('/submit') }}" method="POST">
    @csrf
    <label for="name">Meno:</label>
    <input type="text" id="name" name="name">
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email">
    <br>

    <label for="age">Vek:</label>
    <input type="number" id="age" name="age">
    <br>

    <button type="submit">Odoslat</button>
</form>
