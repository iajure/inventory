-- Insert attributes (elements)
INSERT INTO `attributes` (`id`, `name`) VALUES
(1, 'Color'),
(2, 'Storage');

-- Insert attribute values
INSERT INTO `attribute_value` (`id`, `attribute_parent_id`, `value`) VALUES
(1, 1, 'Black'),
(2, 1, 'White'),
(3, 1, 'Blue'),
(4, 2, '128GB'),
(5, 2, '256GB'),
(6, 2, '512GB');
