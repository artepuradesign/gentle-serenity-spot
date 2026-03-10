import { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Tabs, TabsList, TabsTrigger, TabsContent } from "@/components/ui/tabs";
import { Checkbox } from "@/components/ui/checkbox";
import { ArrowLeft, User, Building2, Mail } from "lucide-react";
import { toast } from "sonner";
import { apiPost } from "@/lib/api";

const Login = () => {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [lembrar, setLembrar] = useState(false);

  const [cpf, setCpf] = useState("");
  const [senhaPf, setSenhaPf] = useState("");
  const [cnpj, setCnpj] = useState("");
  const [senhaPj, setSenhaPj] = useState("");
  const [email, setEmail] = useState("");
  const [senhaEmail, setSenhaEmail] = useState("");

  // Check if user is already saved
  useEffect(() => {
    const savedUser = localStorage.getItem("nu_user");
    if (savedUser) {
      navigate("/painel");
    }
  }, [navigate]);

  const doLogin = async (payload: Record<string, string>) => {
    setLoading(true);
    try {
      const result = await apiPost<{ success: boolean; user: { id: number; is_admin: number; email: string; tipo_conta: string } }>("login.php", payload);
      
      if (lembrar) {
        localStorage.setItem("nu_user", JSON.stringify(result.user));
      } else {
        sessionStorage.setItem("nu_user", JSON.stringify(result.user));
      }

      if (result.user.is_admin) {
        navigate("/admin");
      } else {
        toast.success("Login realizado com sucesso!");
        navigate("/painel");
      }
    } catch (err: unknown) {
      toast.error(err instanceof Error ? err.message : "Credenciais inválidas. Tente novamente.");
    } finally {
      setLoading(false);
    }
  };

  const handleLoginPf = (e: React.FormEvent) => {
    e.preventDefault();
    doLogin({ cpf, senha: senhaPf, tipo: "PF" });
  };

  const handleLoginPj = (e: React.FormEvent) => {
    e.preventDefault();
    doLogin({ cnpj, senha: senhaPj, tipo: "PJ" });
  };

  const handleLoginEmail = (e: React.FormEvent) => {
    e.preventDefault();
    doLogin({ email, senha: senhaEmail });
  };

  const RememberMe = () => (
    <div className="flex items-center gap-2 pt-1">
      <Checkbox
        id="lembrar"
        checked={lembrar}
        onCheckedChange={(checked) => setLembrar(checked === true)}
      />
      <Label htmlFor="lembrar" className="text-sm text-muted-foreground cursor-pointer">
        Lembrar meus dados
      </Label>
    </div>
  );

  return (
    <div className="min-h-screen bg-secondary/30 py-8 px-4 flex items-center justify-center">
      <div className="w-full max-w-lg">
        {/* Header */}
        <div className="flex items-center gap-4 mb-8">
          <Button variant="ghost" size="icon" onClick={() => navigate("/")}>
            <ArrowLeft className="h-5 w-5" />
          </Button>
          <div>
            <h1 className="text-3xl font-extrabold nu-text-gradient font-heading">NU</h1>
          </div>
        </div>

        <Card className="nu-card border-0 nu-card-elevated">
          <CardHeader>
            <CardTitle className="text-2xl text-foreground font-heading">Acessar sua conta</CardTitle>
            <CardDescription>Escolha como deseja entrar</CardDescription>
          </CardHeader>
          <CardContent>
            <Tabs defaultValue="pf">
              <TabsList className="grid grid-cols-3 mb-8">
                <TabsTrigger value="pf" className="flex gap-2 items-center">
                  <User className="h-4 w-4" /> CPF
                </TabsTrigger>
                <TabsTrigger value="pj" className="flex gap-2 items-center">
                  <Building2 className="h-4 w-4" /> CNPJ
                </TabsTrigger>
                <TabsTrigger value="email" className="flex gap-2 items-center">
                  <Mail className="h-4 w-4" /> E-mail
                </TabsTrigger>
              </TabsList>

              <TabsContent value="pf">
                <form onSubmit={handleLoginPf} className="space-y-4">
                  <div>
                    <Label htmlFor="login-cpf">CPF</Label>
                    <Input id="login-cpf" required value={cpf} onChange={e => { const v = e.target.value.replace(/\D/g, '').slice(0, 11); setCpf(v); }} placeholder="00000000000" maxLength={11} inputMode="numeric" />
                  </div>
                  <div>
                    <Label htmlFor="senha-pf">Senha</Label>
                    <Input id="senha-pf" type="password" required value={senhaPf} onChange={e => setSenhaPf(e.target.value)} />
                  </div>
                  <RememberMe />
                  <Button type="submit" variant="hero" className="w-full py-5 rounded-xl" disabled={loading}>
                    {loading ? "Entrando..." : "Entrar"}
                  </Button>
                </form>
              </TabsContent>

              <TabsContent value="pj">
                <form onSubmit={handleLoginPj} className="space-y-4">
                  <div>
                    <Label htmlFor="login-cnpj">CNPJ</Label>
                    <Input id="login-cnpj" required value={cnpj} onChange={e => setCnpj(e.target.value)} placeholder="00.000.000/0000-00" />
                  </div>
                  <div>
                    <Label htmlFor="senha-pj">Senha</Label>
                    <Input id="senha-pj" type="password" required value={senhaPj} onChange={e => setSenhaPj(e.target.value)} />
                  </div>
                  <RememberMe />
                  <Button type="submit" variant="hero" className="w-full py-5 rounded-xl" disabled={loading}>
                    {loading ? "Entrando..." : "Entrar"}
                  </Button>
                </form>
              </TabsContent>

              <TabsContent value="email">
                <form onSubmit={handleLoginEmail} className="space-y-4">
                  <div>
                    <Label htmlFor="login-email">E-mail</Label>
                    <Input id="login-email" type="email" required value={email} onChange={e => setEmail(e.target.value)} placeholder="seu@email.com" />
                  </div>
                  <div>
                    <Label htmlFor="senha-email">Senha</Label>
                    <Input id="senha-email" type="password" required value={senhaEmail} onChange={e => setSenhaEmail(e.target.value)} />
                  </div>
                  <RememberMe />
                  <Button type="submit" variant="hero" className="w-full py-5 rounded-xl" disabled={loading}>
                    {loading ? "Entrando..." : "Entrar"}
                  </Button>
                </form>
              </TabsContent>
            </Tabs>

            <p className="text-center text-sm text-muted-foreground mt-6">
              Não tem conta?{" "}
              <button onClick={() => navigate("/cadastro")} className="text-primary font-medium hover:underline">
                Cadastre-se
              </button>
            </p>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default Login;
