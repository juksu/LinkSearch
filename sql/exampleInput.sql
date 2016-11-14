INSERT INTO url (address) VALUES ("abc.com");
INSERT INTO url (address) VALUES ("def.com");
INSERT INTO url (address) VALUES ("ghi.com");
INSERT INTO url (address) VALUES ("jkl.com");
INSERT INTO url (address) VALUES ("mno.com");
INSERT INTO url (address) VALUES ("pqr.com");

INSERT INTO linksto( sourcepage, link ) VALUES ("abc.com", "def.com");
INSERT INTO linksto( sourcepage, link ) VALUES ("abc.com", "ghi.com");
INSERT INTO linksto( sourcepage, link ) VALUES ("mno.com", "mno.com");
INSERT INTO linksto( sourcepage, link ) VALUES ("mno.com", "pqrurl.com");