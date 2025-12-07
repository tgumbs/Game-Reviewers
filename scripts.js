const express = require("express");
const sqlite3 = require("sqlite3").verbose();
const bodyParser = require("body-parser");
const path = require("path");

const app = express();
const PORT = 3000;

app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, "../public")));

const dbPath = "gameReview.db";
const db = new sqlite3.Database(dbPath, (err) => {
  if (err) {
    console.error("Error opening database:", err.message);
  } else {
    console.log("Connected to database at", dbPath);
  }
});

db.run(`CREATE TABLE IF NOT EXISTS users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL
)`);

app.post("/register", (req, res) => {
  const { username, password } = req.body;
  db.run("INSERT INTO users (username, password) VALUES (?, ?)", [username, password], (err) => {
    if (err) {
      return res.send(`
        <script>
          alert("Registration failed: Username already exists.");
          window.location.href = "/register.html";
        </script>
      `);
    }
    res.send(`
      <script>
        alert("Registration successful! Please log in.");
        window.location.href = "/login.html";
      </script>
    `);
  });
});

app.post("/login", (req, res) => {
  const { username, password } = req.body;
  db.get("SELECT * FROM users WHERE username=? AND password=?", [username, password], (err, row) => {
    if (row) {
      res.send(`
        <script>
          alert("Login successful! Welcome back.");
          window.location.href = "/home.html";
        </script>
      `);
    } else {
      res.send(`
        <script>
          alert("Invalid credentials. Please try again.");
          window.location.href = "/login.html";
        </script>
      `);
    }
  });
});

app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "../public/home.html"));
});

app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});
