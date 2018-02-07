CREATE TABLE `address_book` (
  `address_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `address_book`
  ADD PRIMARY KEY (`address_id`);

ALTER TABLE `address_book`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;
