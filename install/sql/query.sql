IF OBJECT_ID('rox_downloads', 'U') IS NOT NULL DROP TABLE rox_downloads;

CREATE TABLE rox_downloads (
    id smallint PRIMARY KEY IDENTITY(1, 1),
    title varchar(255),
    date datetime not null default(0),
    link varchar(255),
    description varchar(100),
    size varchar(250),
    icon varchar(80) NULL
);

IF OBJECT_ID('rox_sliders', 'U') IS NOT NULL DROP TABLE rox_sliders;

CREATE TABLE rox_sliders (
    id smallint PRIMARY KEY IDENTITY(1, 1),
    title varchar(60),
    image varchar(255),
    link varchar(255) NULL
);

IF OBJECT_ID('rox_notices', 'U') IS NOT NULL DROP TABLE rox_notices;

CREATE TABLE rox_notices (
    id smallint PRIMARY KEY IDENTITY(1, 1),
    title varchar(100),
    body NVARCHAR(MAX),
    author varchar(10),
    description varchar(100) null,
    active_comment int not null default(0),
    date datetime not null default(0),
    slug varchar(255)
);

IF OBJECT_ID('rox_notice_comments', 'U') IS NOT NULL DROP TABLE rox_notice_comments;

CREATE TABLE rox_notice_comments (
    id smallint PRIMARY KEY IDENTITY(1, 1),
    notice_id smallint,
    user_name varchar(10),
    body NVARCHAR(1000),
    date datetime not null default(0),
);

IF COL_LENGTH('Character', 'Avatar') IS NULL
ALTER TABLE
    Character
ADD
    Avatar VARCHAR(255);

IF COL_LENGTH('Character', 'Leadership') IS NULL
ALTER TABLE
    Character
ADD
    Leadership INT NOT NULL DEFAULT(0);

IF COL_LENGTH('MEMB_INFO', 'AccountExpireDate') IS NULL
ALTER TABLE
    MEMB_INFO
ADD
    AccountExpireDate DATETIME;

IF COL_LENGTH('rox_sliders', 'link') IS NULL
ALTER TABLE
    rox_sliders
ADD
    link VARCHAR(255) NULL;

IF COL_LENGTH('rox_notices', 'image') IS NULL
ALTER TABLE
    rox_notices
ADD
    image VARCHAR(255) NULL;

IF COL_LENGTH('rox_notices', 'video') IS NULL
ALTER TABLE
    rox_notices
ADD
    video VARCHAR(255) NULL;

IF COL_LENGTH('MEMB_INFO', 'cash') IS NULL
ALTER TABLE
    MEMB_INFO
ADD
    cash INT NOT NULL DEFAULT(0);

-- Criar tabela de downloads adicionais
IF OBJECT_ID('rox_additional_downloads', 'U') IS NOT NULL DROP TABLE rox_additional_downloads;

CREATE TABLE rox_additional_downloads (
    id smallint PRIMARY KEY IDENTITY(1, 1),
    title varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    link varchar(255) NOT NULL,
    date datetime not null default(getdate()),
    icon varchar(80) NULL,
    size varchar(80) NULL
);

IF OBJECT_ID('rox_donations', 'U') IS NOT NULL DROP TABLE rox_donations;

CREATE TABLE rox_donations(
    id smallint PRIMARY KEY IDENTITY (1, 1),
    bank varchar(20),
    account varchar(10),
    price int not null default(0),
    order_id varchar(255),
    created_at smalldatetime not null default(getdate()),
    status varchar(30) not null default('pending'),
    reward_data nvarchar(max) NULL
);

IF OBJECT_ID('rox_tickets', 'U') IS NOT NULL DROP TABLE rox_tickets;

CREATE TABLE rox_tickets(
    id smallint PRIMARY KEY IDENTITY (1, 1),
    title varchar(80),
    account varchar(10),
    content NVARCHAR(2500),
    created_at smalldatetime not null default(getdate()),
    status varchar(30) not null default('pending'),
);

IF COL_LENGTH('rox_donations', 'reward_data') IS NULL
ALTER TABLE rox_donations ADD reward_data NVARCHAR(MAX) NULL;

IF COL_LENGTH('rox_downloads', 'icon') IS NULL
ALTER TABLE rox_downloads ADD icon VARCHAR(80) NULL;

IF COL_LENGTH('rox_additional_downloads', 'icon') IS NULL
ALTER TABLE rox_additional_downloads ADD icon VARCHAR(80) NULL;

IF COL_LENGTH('rox_additional_downloads', 'size') IS NULL
ALTER TABLE rox_additional_downloads ADD size VARCHAR(80) NULL;

IF OBJECT_ID('rox_ticket_answers', 'U') IS NOT NULL DROP TABLE rox_ticket_answers;

CREATE TABLE rox_ticket_answers(
    id smallint PRIMARY KEY IDENTITY (1, 1),
    account varchar(10),
    ticket_id smallint,
    body NVARCHAR(2500),
    created_at smalldatetime not null default(getdate()),
)

