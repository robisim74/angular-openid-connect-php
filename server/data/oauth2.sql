#
# OAuth 2.0 Server PHP
#

CREATE TABLE oauth_clients (
  client_id             VARCHAR(80)   NOT NULL,
  client_secret         VARCHAR(80),
  redirect_uri          VARCHAR(2000),
  grant_types           VARCHAR(80),
  scope                 VARCHAR(4000),
  user_id               VARCHAR(80),
  PRIMARY KEY (client_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE oauth_access_tokens (
  access_token         VARCHAR(40)  NOT NULL,
  client_id            VARCHAR(80)    NOT NULL,
  user_id              VARCHAR(80),
  expires              TIMESTAMP      NOT NULL,
  scope                VARCHAR(4000),
  PRIMARY KEY (access_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE oauth_authorization_codes (
  authorization_code  VARCHAR(40)     NOT NULL,
  client_id           VARCHAR(80)     NOT NULL,
  user_id             VARCHAR(80),
  redirect_uri        VARCHAR(2000),
  expires             TIMESTAMP       NOT NULL,
  scope               VARCHAR(4000),
  id_token            VARCHAR(1000),
  PRIMARY KEY (authorization_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE oauth_refresh_tokens (
  refresh_token       VARCHAR(40)     NOT NULL,
  client_id           VARCHAR(80)     NOT NULL,
  user_id             VARCHAR(80),
  expires             TIMESTAMP       NOT NULL,
  scope               VARCHAR(4000),
  PRIMARY KEY (refresh_token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE oauth_scopes (
  scope               VARCHAR(80)     NOT NULL,
  is_default          BOOLEAN,
  PRIMARY KEY (scope)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE oauth_jwt (
  client_id           VARCHAR(80)     NOT NULL,
  subject             VARCHAR(80),
  public_key          VARCHAR(2000)   NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE oauth_public_keys (
  client_id            VARCHAR(80),
  public_key           VARCHAR(2000),
  private_key          VARCHAR(2000),
  encryption_algorithm VARCHAR(100) DEFAULT 'RS256'
)

INSERT INTO oauth_clients (client_id, client_secret, redirect_uri, grant_types, scope) VALUES (
  "AngularClient",
  "clientsecret",
  "http://localhost:4200",
  "implicit",
  "openid offline_access profile email groups resource");

INSERT INTO oauth_public_keys (client_id, public_key, private_key, encryption_algorithm) VALUES (
  NULL,
  "-----BEGIN PUBLIC KEY-----
  MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyRry2tkp5ixYsHDPTSyO
  mqnRP21RZjPm7+OuUVAmr3ILfcv3SU8ZcZOp8HdOgC8jS7D6J+B06bKmaMfVagXF
  8RnYPbs/xTkLbD2W9X/h304Y02hVBPt1DqJoPp9hwR7tlS1Q7U6nrzdNAtOlsd7Y
  UKK3E8raT8sFE91erKJtMF0Dw6bcIM1pn48bycoAxiigjKhVq5koAPP/8PwAp9Ye
  +miGhUr0hufRCUdPjQaKsrqQTE86fyMe8IbJZjwa28UYkBuezqM5pIqe2s/YTrDv
  b3HhAWa/RDUZiSX70fBe6CbxCuvw+AT3iY5hk1BkKvfTlwfTjNKFgfKqvuNUwSv8
  xwIDAQAB
  -----END PUBLIC KEY-----",
  "-----BEGIN RSA PRIVATE KEY-----
MIIEpQIBAAKCAQEAyRry2tkp5ixYsHDPTSyOmqnRP21RZjPm7+OuUVAmr3ILfcv3
SU8ZcZOp8HdOgC8jS7D6J+B06bKmaMfVagXF8RnYPbs/xTkLbD2W9X/h304Y02hV
BPt1DqJoPp9hwR7tlS1Q7U6nrzdNAtOlsd7YUKK3E8raT8sFE91erKJtMF0Dw6bc
IM1pn48bycoAxiigjKhVq5koAPP/8PwAp9Ye+miGhUr0hufRCUdPjQaKsrqQTE86
fyMe8IbJZjwa28UYkBuezqM5pIqe2s/YTrDvb3HhAWa/RDUZiSX70fBe6CbxCuvw
+AT3iY5hk1BkKvfTlwfTjNKFgfKqvuNUwSv8xwIDAQABAoIBAQCm6YELdxa5fbEW
sGq+SO8LG0sa86aNxyIzlKtHvdh94Y/8Ft/lrosVo1N2y+8RoQ4QcpENq9QdazOG
3+UXnDcPxz2c7t8c2B3M9slmdX+JEY61WHDIM9SSEuWmpC5EVWEnYXc7nv66BJIc
eIGbwbOUKZj+Cm1rsLtEI4XCjwVFD1ULhK2rIcimWSMEKY8mtnohHyzJZDgvx+Ec
ayZgCGQ/S6Jlohh8fNfpSHR0on7IjHmczwBrH5y5BHVyCmGHm1qFHG6okBp+MQ6g
2sExvZK+Dcd1A+lC5oga0J9MlRoIhLRzaB9J1i65T9NVpbKPERdKQLI//Kix2FRk
cuPzd1QxAoGBAPEZcVidQRWoKqk97BCsuD7Jda8BSt0gQGnFaBSccohPCU1GWgck
5aeQ+RQ0L60t+G+RHQ9N3D8bc9Mo/pIPunBoJqfus1Nf5g++Kj4RPb6zHNYT8nDi
Ph87U2x2iMIy8M5qEGikeejA7LiU3WIx32s4t1hsYavtlsuIwYZO/ZvzAoGBANWI
vQifBtYutmElN7YFZqBSZenhIXOup0BrDnkW+2Mzodu5RIDECVn7oZyV57Uh+91/
u37ozFIEHRtQW8xtluNhFo9KpX7nnkIMuSvmnP2IIsCcF9CO08AUWDFpXxc1NnNj
waAOY8tX5rMzLMce3t2UaOoLQfr5SZwmpsA/9TTdAoGBAMe+5IEeB4YBxRZiDunh
ruOV1MIgt/1rcvIucoRg+SKlGHfFCWFR2FJzcWijs7wukd0cxI6hWw+NlvAizoYE
Mdpe72fCAx/YG6p/SlARyK3thr512C5dwkntxLffnH4H5imdBessGTQUYgqqip+H
4ina20uOv3zJYl1N98dmOgaxAoGBAKx7A/5XvgT5vHWhw2ty11++zvVo1UWFGTIO
h6VF7A9IYICEGRJNxyP4/qTl7UDBT5muGHw9fPTuv7gVY+Ev0EagYMGj0SQ94PaH
IneUktCzyyZ7rzzWcbJgfJCFBbtQT0hLltY7aV6SBRZQyuWYSPsAavJJ36TjAhNw
oRb/Uoi9AoGAK6ZaL+a8a0H0YMrx83XEjwyGoCziWt9YS8korCETSueHzztf1S0v
i8Gr4pjLjvWvHocTJriE4oZWv7rztjthX9mAM0HQUkNk6E861x8FZ2yfJQqfMouj
u/OQIE0onr9+4GY2hlLUzeDoJQyDDwQTNYDHCF1mhXW1EzQcB6dhO8M=
-----END RSA PRIVATE KEY-----",
"RS256");