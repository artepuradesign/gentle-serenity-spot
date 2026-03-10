import { useState } from "react";
import { useSearchParams, useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { ArrowLeft, User, Building2, CheckCircle2 } from "lucide-react";
import { toast } from "sonner";
import { apiPost } from "@/lib/api";
import { ESTADOS_BR } from "@/lib/estados";

const Cadastro = () => {
  const [searchParams] = useSearchParams();
  const navigate = useNavigate();
  const tipoInicial = searchParams.get("tipo") || "pf";
  const [activeTab, setActiveTab] = useState(tipoInicial);
  const [submitted, setSubmitted] = useState(false);
  const [loading, setLoading] = useState(false);

  const [pf, setPf] = useState({
    nome: "", cpf: "", dataNascimento: "", email: "", telefone: "", senha: "", confirmarSenha: "", pin: "", confirmarPin: "",
    cep: "", endereco: "", numero: "", complemento: "", bairro: "", cidade: "", estado: "",
  });

  const [pj, setPj] = useState({
    razaoSocial: "", nomeFantasia: "", cnpj: "", inscricaoEstadual: "",
    email: "", telefone: "", senha: "", confirmarSenha: "", pin: "", confirmarPin: "",
    cep: "", endereco: "", numero: "", complemento: "", bairro: "", cidade: "", estado: "",
    responsavelNome: "", responsavelCpf: "", responsavelTelefone: "",
  });

  const handlePfChange = (field: string, value: string) => setPf(prev => ({ ...prev, [field]: value }));
  const handlePjChange = (field: string, value: string) => setPj(prev => ({ ...prev, [field]: value }));

  const handleSubmitPf = async (e: React.FormEvent) => {
    e.preventDefault();
    if (pf.senha !== pf.confirmarSenha) { toast.error("As senhas não conferem!"); return; }
    if (pf.pin !== pf.confirmarPin) { toast.error("Os PINs não conferem!"); return; }
    if (!/^\d{4}$/.test(pf.pin)) { toast.error("O PIN deve ter exatamente 4 dígitos numéricos!"); return; }
    setLoading(true);
    try {
      await apiPost("cadastro.php", { tipo: "PF", nome: pf.nome, cpf: pf.cpf, dataNascimento: pf.dataNascimento, email: pf.email, telefone: pf.telefone, senha: pf.senha, pin: pf.pin, cep: pf.cep, endereco: pf.endereco, numero: pf.numero, complemento: pf.complemento, bairro: pf.bairro, cidade: pf.cidade, estado: pf.estado });
      toast.success("Cadastro realizado com sucesso!");
      setSubmitted(true);
    } catch (err: unknown) {
      toast.error(err instanceof Error ? err.message : "Erro ao cadastrar. Tente novamente.");
    } finally { setLoading(false); }
  };

  const handleSubmitPj = async (e: React.FormEvent) => {
    e.preventDefault();
    if (pj.senha !== pj.confirmarSenha) { toast.error("As senhas não conferem!"); return; }
    if (pj.pin !== pj.confirmarPin) { toast.error("Os PINs não conferem!"); return; }
    if (!/^\d{4}$/.test(pj.pin)) { toast.error("O PIN deve ter exatamente 4 dígitos numéricos!"); return; }
    setLoading(true);
    try {
      await apiPost("cadastro.php", { tipo: "PJ", razaoSocial: pj.razaoSocial, nomeFantasia: pj.nomeFantasia, cnpj: pj.cnpj, inscricaoEstadual: pj.inscricaoEstadual, email: pj.email, telefone: pj.telefone, senha: pj.senha, pin: pj.pin, responsavelNome: pj.responsavelNome, responsavelCpf: pj.responsavelCpf, responsavelTelefone: pj.responsavelTelefone, cep: pj.cep, endereco: pj.endereco, numero: pj.numero, complemento: pj.complemento, bairro: pj.bairro, cidade: pj.cidade, estado: pj.estado });
      toast.success("Cadastro realizado com sucesso!");
      setSubmitted(true);
    } catch (err: unknown) {
      toast.error(err instanceof Error ? err.message : "Erro ao cadastrar. Tente novamente.");
    } finally { setLoading(false); }
  };

  if (submitted) {
    return (
      <div className="min-h-screen bg-secondary/30 flex items-center justify-center px-4">
        <Card className="max-w-md w-full nu-card border-0 nu-card-elevated">
          <CardContent className="pt-10 pb-8 text-center">
            <div className="w-16 h-16 rounded-full nu-gradient-bg flex items-center justify-center mx-auto mb-6">
              <CheckCircle2 className="h-8 w-8 text-primary-foreground" />
            </div>
            <h2 className="text-2xl font-bold text-foreground font-heading mb-2">Cadastro realizado!</h2>
            <p className="text-muted-foreground mb-6">Sua conta está sendo analisada. Em breve você receberá um e-mail com os próximos passos.</p>
            <Button variant="hero" onClick={() => navigate("/")}>Voltar ao início</Button>
          </CardContent>
        </Card>
      </div>
    );
  }

  const SectionTitle = ({ children }: { children: React.ReactNode }) => (
    <h3 className="text-sm font-semibold text-foreground border-b border-border pb-2 font-heading">{children}</h3>
  );

  return (
    <div className="min-h-screen bg-secondary/30 py-6 px-4 flex justify-center">
      <div className="w-full max-w-lg">
        <div className="flex items-center gap-4 mb-6">
          <Button variant="ghost" size="icon" onClick={() => navigate("/")}>
            <ArrowLeft className="h-5 w-5" />
          </Button>
          <h1 className="text-3xl font-extrabold nu-text-gradient font-heading">NU</h1>
        </div>

        <Card className="nu-card border-0 nu-card-elevated">
          <CardHeader className="pb-4">
            <CardTitle className="text-2xl text-foreground font-heading">Abrir sua conta</CardTitle>
            <CardDescription>Escolha o tipo de conta e preencha seus dados</CardDescription>
          </CardHeader>
          <CardContent>
            <Tabs value={activeTab} onValueChange={setActiveTab}>
              <TabsList className="grid grid-cols-2 mb-6">
                <TabsTrigger value="pf" className="flex gap-2 items-center">
                  <User className="h-4 w-4" /> Pessoa Física
                </TabsTrigger>
                <TabsTrigger value="pj" className="flex gap-2 items-center">
                  <Building2 className="h-4 w-4" /> Pessoa Jurídica
                </TabsTrigger>
              </TabsList>

              {/* PF Form */}
              <TabsContent value="pf">
                <form onSubmit={handleSubmitPf} className="space-y-5">
                  <div className="space-y-4">
                    <SectionTitle>Dados Pessoais</SectionTitle>
                    <div>
                      <Label htmlFor="pf-nome">Nome completo *</Label>
                      <Input id="pf-nome" required value={pf.nome} onChange={e => handlePfChange("nome", e.target.value)} placeholder="Seu nome completo" />
                    </div>
                    <div>
                      <Label htmlFor="pf-cpf">CPF *</Label>
                      <Input id="pf-cpf" required value={pf.cpf} onChange={e => handlePfChange("cpf", e.target.value)} placeholder="000.000.000-00" />
                    </div>
                    <div>
                      <Label htmlFor="pf-nascimento">Data de nascimento *</Label>
                      <Input id="pf-nascimento" type="date" required value={pf.dataNascimento} onChange={e => handlePfChange("dataNascimento", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pf-email">E-mail *</Label>
                      <Input id="pf-email" type="email" required value={pf.email} onChange={e => handlePfChange("email", e.target.value)} placeholder="seu@email.com" />
                    </div>
                    <div>
                      <Label htmlFor="pf-telefone">Telefone *</Label>
                      <Input id="pf-telefone" required value={pf.telefone} onChange={e => handlePfChange("telefone", e.target.value)} placeholder="(00) 00000-0000" />
                    </div>
                  </div>

                  <div className="space-y-4">
                    <SectionTitle>Endereço</SectionTitle>
                    <div>
                      <Label htmlFor="pf-cep">CEP *</Label>
                      <Input id="pf-cep" required value={pf.cep} onChange={e => handlePfChange("cep", e.target.value)} placeholder="00000-000" />
                    </div>
                    <div>
                      <Label htmlFor="pf-endereco">Endereço *</Label>
                      <Input id="pf-endereco" required value={pf.endereco} onChange={e => handlePfChange("endereco", e.target.value)} placeholder="Rua, Avenida..." />
                    </div>
                    <div>
                      <Label htmlFor="pf-numero">Número *</Label>
                      <Input id="pf-numero" required value={pf.numero} onChange={e => handlePfChange("numero", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pf-complemento">Complemento</Label>
                      <Input id="pf-complemento" value={pf.complemento} onChange={e => handlePfChange("complemento", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pf-bairro">Bairro *</Label>
                      <Input id="pf-bairro" required value={pf.bairro} onChange={e => handlePfChange("bairro", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pf-cidade">Cidade *</Label>
                      <Input id="pf-cidade" required value={pf.cidade} onChange={e => handlePfChange("cidade", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pf-estado">Estado *</Label>
                      <Select value={pf.estado} onValueChange={v => handlePfChange("estado", v)}>
                        <SelectTrigger><SelectValue placeholder="Selecione o estado" /></SelectTrigger>
                        <SelectContent>
                          {ESTADOS_BR.map(e => (
                            <SelectItem key={e.sigla} value={e.sigla}>{e.sigla} - {e.nome}</SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="space-y-4">
                    <SectionTitle>Senha de acesso</SectionTitle>
                    <div>
                      <Label htmlFor="pf-senha">Senha *</Label>
                      <Input id="pf-senha" type="password" required value={pf.senha} onChange={e => handlePfChange("senha", e.target.value)} placeholder="Mínimo 8 caracteres" />
                    </div>
                    <div>
                      <Label htmlFor="pf-confirmar">Confirmar senha *</Label>
                      <Input id="pf-confirmar" type="password" required value={pf.confirmarSenha} onChange={e => handlePfChange("confirmarSenha", e.target.value)} />
                    </div>
                  </div>

                  <div className="space-y-4">
                    <SectionTitle>PIN de transações (4 dígitos)</SectionTitle>
                    <p className="text-xs text-muted-foreground">Este PIN será usado para autorizar transferências e também pode ser usado para login.</p>
                    <div>
                      <Label htmlFor="pf-pin">PIN *</Label>
                      <Input id="pf-pin" type="password" required value={pf.pin} onChange={e => handlePfChange("pin", e.target.value.replace(/\D/g, '').slice(0, 4))} placeholder="4 dígitos" maxLength={4} inputMode="numeric" />
                    </div>
                    <div>
                      <Label htmlFor="pf-confirmar-pin">Confirmar PIN *</Label>
                      <Input id="pf-confirmar-pin" type="password" required value={pf.confirmarPin} onChange={e => handlePfChange("confirmarPin", e.target.value.replace(/\D/g, '').slice(0, 4))} placeholder="4 dígitos" maxLength={4} inputMode="numeric" />
                    </div>
                  </div>

                  <Button type="submit" variant="hero" className="w-full py-5 rounded-xl" disabled={loading}>
                    {loading ? "Cadastrando..." : "Criar minha conta"}
                  </Button>
                </form>
              </TabsContent>

              {/* PJ Form */}
              <TabsContent value="pj">
                <form onSubmit={handleSubmitPj} className="space-y-5">
                  <div className="space-y-4">
                    <SectionTitle>Dados da Empresa</SectionTitle>
                    <div>
                      <Label htmlFor="pj-razao">Razão Social *</Label>
                      <Input id="pj-razao" required value={pj.razaoSocial} onChange={e => handlePjChange("razaoSocial", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-fantasia">Nome Fantasia</Label>
                      <Input id="pj-fantasia" value={pj.nomeFantasia} onChange={e => handlePjChange("nomeFantasia", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-cnpj">CNPJ *</Label>
                      <Input id="pj-cnpj" required value={pj.cnpj} onChange={e => handlePjChange("cnpj", e.target.value)} placeholder="00.000.000/0000-00" />
                    </div>
                    <div>
                      <Label htmlFor="pj-ie">Inscrição Estadual</Label>
                      <Input id="pj-ie" value={pj.inscricaoEstadual} onChange={e => handlePjChange("inscricaoEstadual", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-email">E-mail *</Label>
                      <Input id="pj-email" type="email" required value={pj.email} onChange={e => handlePjChange("email", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-telefone">Telefone *</Label>
                      <Input id="pj-telefone" required value={pj.telefone} onChange={e => handlePjChange("telefone", e.target.value)} placeholder="(00) 00000-0000" />
                    </div>
                  </div>

                  <div className="space-y-4">
                    <SectionTitle>Responsável Legal</SectionTitle>
                    <div>
                      <Label htmlFor="pj-resp-nome">Nome completo *</Label>
                      <Input id="pj-resp-nome" required value={pj.responsavelNome} onChange={e => handlePjChange("responsavelNome", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-resp-cpf">CPF *</Label>
                      <Input id="pj-resp-cpf" required value={pj.responsavelCpf} onChange={e => handlePjChange("responsavelCpf", e.target.value)} placeholder="000.000.000-00" />
                    </div>
                    <div>
                      <Label htmlFor="pj-resp-tel">Telefone *</Label>
                      <Input id="pj-resp-tel" required value={pj.responsavelTelefone} onChange={e => handlePjChange("responsavelTelefone", e.target.value)} />
                    </div>
                  </div>

                  <div className="space-y-4">
                    <SectionTitle>Endereço</SectionTitle>
                    <div>
                      <Label htmlFor="pj-cep">CEP *</Label>
                      <Input id="pj-cep" required value={pj.cep} onChange={e => handlePjChange("cep", e.target.value)} placeholder="00000-000" />
                    </div>
                    <div>
                      <Label htmlFor="pj-endereco">Endereço *</Label>
                      <Input id="pj-endereco" required value={pj.endereco} onChange={e => handlePjChange("endereco", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-numero">Número *</Label>
                      <Input id="pj-numero" required value={pj.numero} onChange={e => handlePjChange("numero", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-complemento">Complemento</Label>
                      <Input id="pj-complemento" value={pj.complemento} onChange={e => handlePjChange("complemento", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-bairro">Bairro *</Label>
                      <Input id="pj-bairro" required value={pj.bairro} onChange={e => handlePjChange("bairro", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-cidade">Cidade *</Label>
                      <Input id="pj-cidade" required value={pj.cidade} onChange={e => handlePjChange("cidade", e.target.value)} />
                    </div>
                    <div>
                      <Label htmlFor="pj-estado">Estado *</Label>
                      <Select value={pj.estado} onValueChange={v => handlePjChange("estado", v)}>
                        <SelectTrigger><SelectValue placeholder="Selecione o estado" /></SelectTrigger>
                        <SelectContent>
                          {ESTADOS_BR.map(e => (
                            <SelectItem key={e.sigla} value={e.sigla}>{e.sigla} - {e.nome}</SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  <div className="space-y-4">
                    <SectionTitle>Senha de acesso</SectionTitle>
                    <div>
                      <Label htmlFor="pj-senha">Senha *</Label>
                      <Input id="pj-senha" type="password" required value={pj.senha} onChange={e => handlePjChange("senha", e.target.value)} placeholder="Mínimo 8 caracteres" />
                    </div>
                    <div>
                      <Label htmlFor="pj-confirmar">Confirmar senha *</Label>
                      <Input id="pj-confirmar" type="password" required value={pj.confirmarSenha} onChange={e => handlePjChange("confirmarSenha", e.target.value)} />
                    </div>
                  </div>

                  <div className="space-y-4">
                    <SectionTitle>PIN de transações (4 dígitos)</SectionTitle>
                    <p className="text-xs text-muted-foreground">Este PIN será usado para autorizar transferências e também pode ser usado para login.</p>
                    <div>
                      <Label htmlFor="pj-pin">PIN *</Label>
                      <Input id="pj-pin" type="password" required value={pj.pin} onChange={e => handlePjChange("pin", e.target.value.replace(/\D/g, '').slice(0, 4))} placeholder="4 dígitos" maxLength={4} inputMode="numeric" />
                    </div>
                    <div>
                      <Label htmlFor="pj-confirmar-pin">Confirmar PIN *</Label>
                      <Input id="pj-confirmar-pin" type="password" required value={pj.confirmarPin} onChange={e => handlePjChange("confirmarPin", e.target.value.replace(/\D/g, '').slice(0, 4))} placeholder="4 dígitos" maxLength={4} inputMode="numeric" />
                    </div>
                  </div>

                  <Button type="submit" variant="hero" className="w-full py-5 rounded-xl" disabled={loading}>
                    {loading ? "Cadastrando..." : "Criar conta empresarial"}
                  </Button>
                </form>
              </TabsContent>
            </Tabs>

            <p className="text-center text-sm text-muted-foreground mt-6">
              Já tem conta?{" "}
              <button onClick={() => navigate("/login")} className="text-primary font-medium hover:underline">
                Fazer login
              </button>
            </p>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default Cadastro;
