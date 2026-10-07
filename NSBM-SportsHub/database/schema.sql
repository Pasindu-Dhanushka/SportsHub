CREATE DATABASE IF NOT EXISTS sports_hub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sports_hub;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS participation;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS match_results;
DROP TABLE IF EXISTS tournament_registrations;
DROP TABLE IF EXISTS tournaments;
DROP TABLE IF EXISTS sports_matches;
DROP TABLE IF EXISTS training_sessions;
DROP TABLE IF EXISTS memberships;
DROP TABLE IF EXISTS clubs;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  student_id VARCHAR(40) NULL UNIQUE,
  faculty VARCHAR(120) NULL,
  role ENUM('admin','student') NOT NULL DEFAULT 'student',
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE clubs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(140) NOT NULL,
  sport VARCHAR(80) NOT NULL,
  coach VARCHAR(120) NOT NULL,
  venue VARCHAR(160) NOT NULL,
  training_days VARCHAR(120) NOT NULL,
  capacity INT UNSIGNED NOT NULL DEFAULT 30,
  description TEXT NOT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE memberships (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  club_id INT UNSIGNED NOT NULL,
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  joined_at DATE NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_membership (user_id,club_id),
  CONSTRAINT fk_membership_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_membership_club FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE training_sessions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  club_id INT UNSIGNED NOT NULL,
  title VARCHAR(140) NOT NULL,
  session_date DATE NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  venue VARCHAR(160) NOT NULL,
  coach VARCHAR(120) NOT NULL,
  notes TEXT NULL,
  status ENUM('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_training_club FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE,
  INDEX idx_training_date (session_date)
) ENGINE=InnoDB;

CREATE TABLE sports_matches (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  club_id INT UNSIGNED NOT NULL,
  opponent VARCHAR(140) NOT NULL,
  competition VARCHAR(160) NOT NULL,
  match_date DATE NOT NULL,
  start_time TIME NOT NULL,
  venue VARCHAR(160) NOT NULL,
  home_away ENUM('home','away','neutral') NOT NULL DEFAULT 'home',
  status ENUM('scheduled','completed','cancelled') NOT NULL DEFAULT 'scheduled',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_match_club FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE,
  INDEX idx_match_date (match_date)
) ENGINE=InnoDB;

CREATE TABLE tournaments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  sport VARCHAR(100) NOT NULL,
  location VARCHAR(180) NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  registration_deadline DATE NOT NULL,
  max_participants INT UNSIGNED NOT NULL DEFAULT 50,
  description TEXT NOT NULL,
  status ENUM('open','closed','completed','cancelled') NOT NULL DEFAULT 'open',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE tournament_registrations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tournament_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  team_name VARCHAR(140) NULL,
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_tournament_user (tournament_id,user_id),
  CONSTRAINT fk_reg_tournament FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE,
  CONSTRAINT fk_reg_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE match_results (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  match_id INT UNSIGNED NOT NULL UNIQUE,
  nsbm_score INT UNSIGNED NOT NULL DEFAULT 0,
  opponent_score INT UNSIGNED NOT NULL DEFAULT 0,
  result ENUM('won','draw','lost') NOT NULL,
  notes TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_result_match FOREIGN KEY (match_id) REFERENCES sports_matches(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE bookings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  club_id INT UNSIGNED NULL,
  booking_type ENUM('facility','equipment') NOT NULL,
  item_name VARCHAR(160) NOT NULL,
  booking_date DATE NOT NULL,
  start_time TIME NOT NULL,
  end_time TIME NOT NULL,
  purpose TEXT NOT NULL,
  status ENUM('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  admin_note TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_booking_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_booking_club FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE SET NULL,
  INDEX idx_booking_date (booking_date),
  INDEX idx_booking_status (status)
) ENGINE=InnoDB;

CREATE TABLE participation (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  club_id INT UNSIGNED NOT NULL,
  event_type ENUM('training','match','tournament','volunteer') NOT NULL,
  event_name VARCHAR(180) NOT NULL,
  event_date DATE NOT NULL,
  points INT UNSIGNED NOT NULL DEFAULT 0,
  remarks TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_participation_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_participation_club FOREIGN KEY (club_id) REFERENCES clubs(id) ON DELETE CASCADE,
  INDEX idx_participation_date (event_date)
) ENGINE=InnoDB;
