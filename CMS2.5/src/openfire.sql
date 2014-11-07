INSERT  INTO ofproperty(NAME,propValue)VALUES
('jdbcProvider.driver','com.mysql.jdbc.Driver'),
('jdbcProvider.connectionString','jdbc:mysql://localhost/cms?user=root&password=admin&useUnicode=true&characterEncoding=utf8'),
('admin.authorizedJIDs','admin@tanjun'),
('jdbcAuthProvider.passwordSQL','SELECT loginpassword FROM frontuser WHERE loginName=?'),
('jdbcAuthProvider.passwordType','plain'),
('jdbcUserProvider.loadUserSQL','SELECT name,email FROM frontuser WHERE loginName=?'),
('jdbcUserProvider.userCountSQL','SELECT COUNT(*) FROM frontuser'),
('jdbcUserProvider.allUsersSQL','SELECT loginName FROM frontuser'),
('jdbcUserProvider.usernameField','loginName'),
('jdbcUserProvider.nameField','name'),
('jdbcUserProvider.emailField','email');

UPDATE ofProperty SET propValue='org.jivesoftware.openfire.user.JDBCUserProvider' WHERE 

NAME='provider.user.className';
UPDATE ofProperty SET propValue='org.jivesoftware.openfire.auth.JDBCAuthProvider' WHERE 

NAME='provider.auth.className';