# fb-friends
Teste para trazer os amigos do facebook usando a API V4 do Facebook

De acordo com a [documentação](https://developers.facebook
.com/docs/apps/faq#unable_full_friend_list), não é mais possivel trazer a lista completa de
amigos em /me/friends, somente usuários que já aceitaram as permissões do seu aplicativo.

Porém, é possível trazer a lista completa de amigos em /me/taggable_friends para criar tags para
amigos em posts. Os ids dos amigos retornados nesta chamada são exclusivos para este fim, portanto
não irão funcionar para outras chamadas da API usando estes ids.
